<?php
/**
* The main importer class, extending the slightly modified WP importer 2.0 class WXRImporter
*/

namespace NtWPImporter;

use XMLReader;

class Importer extends WXRImporter {

    /**
    * Time in milliseconds, marking the beginning of the import.
    *
    * @var float
    */
    private $start_time;

    /**
    * Importer constructor.
    * Look at the parent constructor for the options parameters.
    *
    * @param array  $options The importer options.
    * @param object $logger  The logger object.
    */
    public function __construct( $options = array(), $logger = null ) {
        parent::__construct( $options );

        //$this->set_logger( $logger );

        // Check, if a new AJAX request is required.
        add_filter( 'wxr_importer.pre_process.post', array( $this, 'new_ajax_request_maybe' ) );
    }

    /**
    * Get the XML reader for the file.
    *
    * @param string $file Path to the XML file.
    *
    * @return XMLReader|boolean Reader instance on success, false otherwise.
    */
    protected function get_reader( $file ) {
        // Avoid loading external entities for security
        $old_value = null;
        if ( function_exists( 'libxml_disable_entity_loader' ) ) {
            // $old_value = libxml_disable_entity_loader( true );
        }

        if ( ! class_exists( 'XMLReader' ) ) {
            //$this->logger->critical( esc_html__( 'The XMLReader class is missing! Please install the XMLReader PHP extension on your server', 'electron' ) );

            return false;
        }

        $reader = new XMLReader();
        $status = $reader->open( $file );

        if ( ! is_null( $old_value ) ) {
            // libxml_disable_entity_loader( $old_value );
        }

        if ( ! $status ) {
            //$this->logger->error( esc_html__( 'Could not open the XML file for parsing!', 'electron' ) );

            return false;
        }

        return $reader;
    }

    /**
    * Get the basic import content data.
    * Which elements are present in this import file (check possible elements in the $data variable)?
    *
    * @param $file
    *
    * @return array|bool
    */
    public function get_basic_import_content_data( $file ) {
        $data = array(
            'users' => false,
            'categories' => false,
            'tags' => false,
            'terms' => false,
            'posts' => false,
        );

        // Get the XML reader and open the file.
        $reader = $this->get_reader( $file );

        if ( empty( $reader ) ) {
            return false;
        }

        // Start parsing!
        while ( $reader->read() ) {
            // Only deal with element opens.
            if ( $reader->nodeType !== XMLReader::ELEMENT ) {
                continue;
            }

            switch ( $reader->name ) {
                case 'wp:author':
                // Skip, if the users were already detected.
                if ( $data['users'] ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_author_node( $node );

                // Skip, if there was an error in parsing the author node.
                if ( is_wp_error( $parsed ) ) {
                    $reader->next();
                    break;
                }

                $data['users'] = true;

                // Handled everything in this node, move on to the next.
                $reader->next();
                break;

                case 'item':
                // Skip, if the posts were already detected.
                if ( $data['posts'] ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_post_node( $node );

                // Skip, if there was an error in parsing the item node.
                if ( is_wp_error( $parsed ) ) {
                    $reader->next();
                    break;
                }

                $data['posts'] = true;

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:category':
                $data['categories'] = true;

                // Handled everything in this node, move on to the next
                $reader->next();
                break;
                case 'wp:tag':
                $data['tags'] = true;

                // Handled everything in this node, move on to the next
                $reader->next();
                break;
                case 'wp:term':
                $data['terms'] = true;

                // Handled everything in this node, move on to the next
                $reader->next();
                break;
            }
        }

        return $data;
    }


    /**
    * Get the number of posts (posts, pages, CPT, attachments), that the import file has.
    *
    * @param $file
    *
    * @return int
    */
    public function get_number_of_posts_to_import( $file ) {
        $reader  = $this->get_reader( $file );
        $counter = 0;

        if ( empty( $reader ) ) {
            return $counter;
        }

        // Start parsing!
        while ( $reader->read() ) {
            // Only deal with element opens.
            if ( $reader->nodeType !== XMLReader::ELEMENT ) {
                continue;
            }

            if ( 'item' == $reader->name ) {
                $node   = $reader->expand();
                $parsed = $this->parse_post_node( $node );

                // Skip, if there was an error in parsing the item node.
                if ( is_wp_error( $parsed ) ) {
                    $reader->next();
                    continue;
                }

                $counter++;
            }
        }

        return $counter;
    }

    /**
    * The main controller for the actual import stage.
    *
    * @param string $file    Path to the WXR file for importing.
    * @param array  $options Import options (which parts to import).
    *
    * @return boolean
    */
    public function import( $file, $options = array() ) {
        add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
        add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

        // Start the import timer.
        $this->start_time = microtime( true );

        // Set the existing import data, from previous AJAX call, if any.
        $this->restore_import_data_transient();

        // Set the import options defaults.
        if ( empty( $options ) ) {
            $options = array(
                'users' => false,
                'categories' => true,
                'tags' => true,
                'terms' => true,
                'posts' => true,
            );
        }

        $result = $this->import_start( $file );

        if ( is_wp_error( $result ) ) {
            //$this->logger->error( esc_html__( 'Content import start error: ', 'electron' ) . $result->get_error_message() );

            return false;
        }

        // Get the actual XML reader.
        $reader = $this->get_reader( $file );

        if ( empty( $reader ) ) {
            return false;
        }

        // Set the version to compatibility mode first
        $this->version = '1.0';

        // Reset other variables
        $this->base_url = '';

        // Start parsing!
        while ( $reader->read() ) {
            // Only deal with element opens.
            if ( $reader->nodeType !== XMLReader::ELEMENT ) {
                continue;
            }

            switch ( $reader->name ) {
                case 'wp:wxr_version':
                // Upgrade to the correct version
                $this->version = $reader->readString();

                if ( version_compare( $this->version, self::MAX_WXR_VERSION, '>' ) ) {
                    /*
                    $this->logger->warning( sprintf(
                    __( 'This WXR file (version %s) is newer than the importer (version %s) and may not be supported. Please consider updating.', 'electron' ),
                    $this->version,
                    self::MAX_WXR_VERSION
                    ) );
                    */
                }

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:base_site_url':
                $this->base_url = $reader->readString();

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'item':
                if ( empty( $options['posts'] ) ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_post_node( $node );

                if ( is_wp_error( $parsed ) ) {
                    $this->log_error( $parsed );

                    // Skip the rest of this post
                    $reader->next();
                    break;
                }

                $this->process_post( $parsed['data'], $parsed['meta'], $parsed['comments'], $parsed['terms'] );

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:author':
                if ( empty( $options['users'] ) ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_author_node( $node );

                if ( is_wp_error( $parsed ) ) {
                    $this->log_error( $parsed );

                    // Skip the rest of this post
                    $reader->next();
                    break;
                }

                $status = $this->process_author( $parsed['data'], $parsed['meta'] );

                if ( is_wp_error( $status ) ) {
                    $this->log_error( $status );
                }

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:category':
                if ( empty( $options['categories'] ) ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_term_node( $node, 'category' );

                if ( is_wp_error( $parsed ) ) {
                    $this->log_error( $parsed );

                    // Skip the rest of this post
                    $reader->next();
                    break;
                }

                $status = $this->process_term( $parsed['data'], $parsed['meta'] );

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:tag':
                if ( empty( $options['tags'] ) ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_term_node( $node, 'tag' );

                if ( is_wp_error( $parsed ) ) {
                    $this->log_error( $parsed );

                    // Skip the rest of this post
                    $reader->next();
                    break;
                }

                $status = $this->process_term( $parsed['data'], $parsed['meta'] );

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                case 'wp:term':
                if ( empty( $options['terms'] ) ) {
                    $reader->next();
                    break;
                }

                $node   = $reader->expand();
                $parsed = $this->parse_term_node( $node );

                if ( is_wp_error( $parsed ) ) {
                    $this->log_error( $parsed );

                    // Skip the rest of this post
                    $reader->next();
                    break;
                }

                $status = $this->process_term( $parsed['data'], $parsed['meta'] );

                // Handled everything in this node, move on to the next
                $reader->next();
                break;

                default:
                // Skip this node, probably handled by something already
                break;
            }
        }

        // Now that we've done the main processing, do any required
        // post-processing and remapping.
        $this->post_process();

        if ( $this->options['aggressive_url_search'] ) {
            $this->replace_attachment_urls_in_content();
        }

        $this->remap_featured_images();

        $this->import_end();

        // Set the current importer state, so the data can be used on the next AJAX call.
        $this->set_current_importer_data();

        return true;
    }

    /**
    * Import users only.
    *
    * @param string $file Path to the import file.
    */
    public function import_users( $file ) {
        return $this->import( $file, array( 'users' => true ) );
    }

    /**
    * Import categories only.
    *
    * @param string $file Path to the import file.
    */
    public function import_categories( $file ) {
        return $this->import( $file, array( 'categories' => true ) );
    }

    /**
    * Import tags only.
    *
    * @param string $file Path to the import file.
    */
    public function import_tags( $file ) {
        return $this->import( $file, array( 'tags' => true ) );
    }

    /**
    * Import terms only.
    *
    * @param string $file Path to the import file.
    */
    public function import_terms( $file ) {
        return $this->import( $file, array( 'terms' => true ) );
    }

    /**
    * Import posts only.
    *
    * @param string $file Path to the import file.
    */
    public function import_posts( $file ) {
        return $this->import( $file, array( 'posts' => true ) );
    }

    /**
    * Check if we need to create a new AJAX request, so that server does not timeout.
    * And fix the import warning for missing post author.
    *
    * @param array $data current post data.
    * @return array
    */
    public function new_ajax_request_maybe( $data ) {
        $time = microtime( true ) - $this->start_time;

        // We should make a new ajax call, if the time is right.
        if ( $time > apply_filters( 'pt-importer/time_for_one_ajax_call', 20 ) ) {
            $response = apply_filters( 'pt-importer/new_ajax_request_response_data', array(
                'status'                => 'newAJAX',
                'log'                   => 'Time for new AJAX request!: ' . $time,
                'num_of_imported_posts' => count( $this->mapping['post'] ),
            ) );

            // Add message to log file.
            //$this->logger->info( esc_html__( 'New AJAX call!', 'electron' ) );

            // Set the current importer state, so it can be continued on the next AJAX call.
            $this->set_current_importer_data();

            // Send the request for a new AJAX call.
            wp_send_json( $response );
        }

        // Set importing author to the current user.
        // Fixes the [WARNING] Could not find the author for ... log warning messages.
        $current_user_obj    = wp_get_current_user();
        $data['post_author'] = $current_user_obj->user_login;

        return $data;
    }

    /**
    * Save current importer data to the DB, for later use.
    */
    public function set_current_importer_data() {
        $data = apply_filters( 'pt-importer/set_current_importer_data', array(
            'options' => $this->options,
            'mapping' => $this->mapping,
            'requires_remapping' => $this->requires_remapping,
            'exists' => $this->exists,
            'user_slug_override' => $this->user_slug_override,
            'url_remap' => $this->url_remap,
            'featured_images' => $this->featured_images,
        ) );

        $this->save_current_import_data_transient( $data );
    }

    /**
    * Set the importer data to the transient.
    *
    * @param array $data Data to be saved to the transient.
    */
    public function save_current_import_data_transient( $data ) {
        set_transient( 'pt_importer_data', $data, MINUTE_IN_SECONDS );
    }

    /**
    * Restore the importer data from the transient.
    *
    * @return boolean
    */
    public function restore_import_data_transient() {
        if ( $data = get_transient( 'pt_importer_data' ) ) {
            $this->options            = empty( $data['options'] ) ? array() : $data['options'];
            $this->mapping            = empty( $data['mapping'] ) ? array() : $data['mapping'];
            $this->requires_remapping = empty( $data['requires_remapping'] ) ? array() : $data['requires_remapping'];
            $this->exists             = empty( $data['exists'] ) ? array() : $data['exists'];
            $this->user_slug_override = empty( $data['user_slug_override'] ) ? array() : $data['user_slug_override'];
            $this->url_remap          = empty( $data['url_remap'] ) ? array() : $data['url_remap'];
            $this->featured_images    = empty( $data['featured_images'] ) ? array() : $data['featured_images'];

            do_action( 'pt-importer/restore_import_data_transient' );

            return true;
        }

        return false;
    }

    /**
    * Get the importer mapping data.
    *
    * @return array An empty array or an array of mapping data.
    */
    public function get_mapping() {
        return $this->mapping;
    }
}
