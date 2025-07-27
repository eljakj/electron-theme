<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Electron_Woo_Taxonomy_List extends Widget_Base {
    use Electron_Helper;
    public function get_name() {
        return 'electron-woo-taxonomy-list';
    }
    public function get_title() {
        return 'Taxonomy List';
    }
    public function get_icon() {
        return 'eicon-post-list';
    }
    public function get_categories() {
        return [ 'electron-woo' ];
    }
    public function get_keywords() {
        return [ 'woocommerce', 'shop', 'store', 'cat', 'wc', 'woo', 'product', 'list', 'tax' ];
    }
    public function get_style_depends() {
        return [ 'electron-taxonomy-list' ];
    }
    // Registering Controls
    protected function register_controls() {
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'general_settings',
            [
                'label' => esc_html__('CATEGORY LIST', 'electron'),
            ]
        );
        $this->add_control( 'type',
            [
                'label' => esc_html__( 'Layout', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'list',
                'options' => [
                    'list' => esc_html__( 'List', 'electron' ),
                    'grid' => esc_html__( 'Grid', 'electron' ),
                    'slider' => esc_html__( 'Slider', 'electron' ),
                ]
            ]
        );
        $this->add_responsive_control( 'col',
            [
                'label' => esc_html__( 'Column', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'default' => 4,
                'selectors' => ['{{WRAPPER}} .layout-grid .electron-taxonomy-list' => 'grid-template-columns: repeat({{SIZE}}, 1fr);'],
                'condition' => [ 'type' => 'grid' ]
            ]
        );
        $this->add_responsive_control('column_gap',
            [
                'label' => __( 'Columns Gap', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .layout-grid .electron-taxonomy-list' => 'gap: {{SIZE}}px;'],
                'condition' => [ 'type' => 'grid' ]
            ]
        );
        $this->add_control( 'style',
            [
                'label' => esc_html__( 'Style', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'electron' ),
                    'style-2' => esc_html__( 'Style 2', 'electron' ),
                    'style-3' => esc_html__( 'Style 3', 'electron' ),
                    'style-4' => esc_html__( 'Style 4', 'electron' )
                ]
            ]
        );
        $this->add_control( 'taxonomy',
            [
                'label' => esc_html__( 'Taxonomy', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'cat',
                'options' => [
                    'cat'   => esc_html__( 'Product Category', 'electron' ),
                    'tag'   => esc_html__( 'Product Tag', 'electron' ),
                    'brand' => esc_html__( 'Product Brands', 'electron' ),
                ]
            ]
        );
        $this->add_control( 'cats',
            [
                'label' => esc_html__( 'Select Category', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_cat'),
                'description' => 'Select Category(s) to Exclude',
                'condition' => ['taxonomy' => 'cat']
            ]
        );
        $this->add_control( 'tags',
            [
                'label' => esc_html__( 'Select Tag', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_cpt_taxonomies('product_tag'),
                'description' => 'Select Tag(s) to Exclude',
                'condition' => ['taxonomy' => 'tag']
            ]
        );
        $electronOptions = get_option('electron');
        $brands1 = taxonomy_exists('electron_product_brands') ? $this->electron_cpt_taxonomies('electron_product_brands') : array();
        $brands2 = taxonomy_exists('product_brand') ? $this->electron_cpt_taxonomies('product_brand') : array();
        $brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;
        $this->add_control( 'brands',
            [
                'label' => esc_html__( 'Select Brand', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $brandsTax,
                'description' => 'Select Brand(s) to Exclude',
                'condition' => ['taxonomy' => 'brand']
            ]
        );
        $this->add_control( 'attributes',
            [
                'label' => esc_html__( 'Select Attribute', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->electron_woo_attributes(),
                'condition' => [ 'taxonomy' => 'attr' ]
            ]
        );
        $this->add_control( 'attr_terms',
            [
                'label' => esc_html__( 'Select Attribute Terms', 'electron' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->electron_woo_attributes_taxonomies(),
                'condition' => [ 'taxonomy' => 'attr' ]
            ]
        );
        $this->add_control( 'filter_type',
            [
                'label' => esc_html__( 'Taxonomy Filter Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'include',
                'options' => [
                    'include' => esc_html__( 'Include', 'electron' ),
                    'exclude' => esc_html__( 'Exclude', 'electron' )
                ]
            ]
        );
        $this->add_control( 'order',
            [
                'label' => esc_html__( 'Select Order', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => esc_html__( 'Ascending', 'electron' ),
                    'DESC' => esc_html__( 'Descending', 'electron' )
                ],
                'default' => 'ASC'
            ]
        );
        $this->add_control( 'orderby',
            [
                'label' => esc_html__( 'Order By', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'id' => esc_html__( 'Post ID', 'electron' ),
                    'menu_order' => esc_html__( 'Menu Order', 'electron' ),
                    'rand' => esc_html__( 'Random', 'electron' ),
                    'date' => esc_html__( 'Date', 'electron' ),
                    'title' => esc_html__( 'Title', 'electron' ),
                ],
                'default' => 'id',
            ]
        );
        $this->add_responsive_control('min_width',
            [
                'label' => __( 'Container Min Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-taxonomy-list' => 'min-width: {{SIZE}}px;']
            ]
        );
        $this->add_responsive_control('min_height',
            [
                'label' => __( 'List Item Min Height', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .taxonomy-item' => 'min-height: {{SIZE}}px;']
            ]
        );
        $this->add_control( 'show_image',
            [
                'label' => esc_html__( 'Image Display', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes'
            ]
        );
        $this->add_control( 'img_type',
            [
                'label' => esc_html__( 'Image Type', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'thumb',
                'options' => [
                    'thumb' => esc_html__( 'Thumbnail', 'electron' ),
                    'img'   => esc_html__( 'Custom Image', 'electron' ),
                    'icon'  => esc_html__( 'Custom Icon', 'electron' ),
                ],
                'condition' => ['show_image' => 'yes']
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control( 'icon',
            [
                'label' => esc_html__( 'Icon', 'electron' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => '',
                    'library' => 'solid'
                ]
            ]
        );
        $repeater->add_control( 'icon_color2',
            [
                'label' => esc_html__( 'Custom Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.taxonomy-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.taxonomy-item svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
            ]
        );
        $this->add_control( 'icons',
            [
                'label' => esc_html__( 'Add Icons', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '#Icon',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $this->add_responsive_control( 'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item i' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .taxonomy-item svg' => 'width: {{SIZE}}px;height: {{SIZE}}px;'
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 35
                ],
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $this->add_control( 'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $this->add_control( 'icon_hvrcolor',
            [
                'label' => esc_html__( 'Hover Icon Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-item:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item:hover svg' => 'fill: {{VALUE}};'
                ],
                'default' => '',
                'condition' => [ 'show_image' => 'yes','img_type' => 'icon' ]
            ]
        );
        $repeater2 = new Repeater();
        $repeater2->add_control( 'image',
            [
                'label' => esc_html__( 'Image', 'electron' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $this->add_control( 'images',
            [
                'label' => esc_html__( 'Add Images', 'electron' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater2->get_controls(),
                'title_field' => '#Image',
                'condition' => [ 'show_image' => 'yes','img_type' => 'img' ]
            ]
        );
        $this->add_responsive_control( 'image_size',
            [
                'label' => esc_html__( 'Image Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .taxonomy-thumb img' => 'max-width: {{SIZE}}px;'],
                'default' => [],
                'condition' => ['show_image' => 'yes','img_type!' => 'icon']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'thumbnail',
                'condition' => ['show_image' => 'yes']
            ]
        );
        $this->add_control( 'mob_img_size_heading',
            [
                'label' => esc_html__( 'Mobile Image Size', 'electron' ),
                'type' => Controls_Manager::HEADING,
                'condition' => ['show_image' => 'yes']
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'mob_thumbnail',
            'default' => 'woocommerce_thumbnail',
            'condition' => ['show_image' => 'yes']
            ]
        );
        $this->add_control( 'count',
            [
                'label' => esc_html__( 'Taxonomy Item Count', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control( 'desc',
            [
                'label' => esc_html__( 'Taxonomy Item Description', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'desc_position',
            [
                'label' => esc_html__( 'Description Position', 'electron' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__( 'Top', 'electron' ),
                    'bottom' => esc_html__( 'Bottom', 'electron' ),
                    'right'   => esc_html__( 'Right', 'electron' ),
                    'left'  => esc_html__( 'Left', 'electron' ),
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_responsive_control( 'desc_size',
            [
                'label' => esc_html__( 'Description Max Width', 'electron' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500
                    ]
                ],
                'selectors' => ['{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'max-width: {{SIZE}}px;'],
                'default' => [],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
       /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('slider_options_section',
            [
                'label'=> esc_html__( 'SLIDER OPTIONS', 'electron' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => ['type' => 'slider']
            ]
        );
        $this->add_control( 'loop',
            [
                'label' => esc_html__( 'Infinite', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'nav',
            [
                'label' => esc_html__( 'Navigation', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control( 'dots',
            [
                'label' => esc_html__( 'Dots', 'electron' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control( 'space',
            [
                'label' => esc_html__( 'Gap', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => 10
            ]
        );
        $this->add_control( 'speed',
            [
                'label' => esc_html__( 'Speed', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 10000,
                'step' => 100,
                'default' => 1000
            ]
        );
        $this->add_control( 'mditems',
            [
                'label' => esc_html__( 'Items', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'step' => 1,
                'default' => 5
            ]
        );
        $this->add_control( 'smitems',
            [
                'label' => esc_html__( 'Items Tablet', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 8,
                'step' => 1,
                'default' => 3
            ]
        );
        $this->add_control( 'xsitems',
            [
                'label' => esc_html__( 'Items Phone', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 3,
                'step' => 1,
                'default' => 2
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section( 'style_section',
            [
                'label'=> esc_html__( 'STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control( 'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'bg_hvrcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'brd_color',
            [
                'label' => esc_html__( 'Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list' => 'border-color:{{VALUE}};',
                    '{{WRAPPER}} .taxonomy-item + .taxonomy-item' => 'border-top-color:{{VALUE}};',
                ]
            ]
        );
        $this->add_control( 'title_color',
            [
                'label' => esc_html__( 'Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'title_hvrcolor',
            [
                'label' => esc_html__( 'Hover Title Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-item:hover .taxonomy-title' => 'color:{{VALUE}};' ],
            ]
        );
        $this->add_control( 'count_bgcolor',
            [
                'label' => esc_html__( 'Count Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-count' => 'background-color:{{VALUE}};' ],
                'condition' => ['count' => 'yes']
            ]
        );
        $this->add_control( 'count_color',
            [
                'label' => esc_html__( 'Count Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-count' => 'color:{{VALUE}};' ],
                'condition' => ['count' => 'yes']
            ]
        );
        $this->add_control( 'desc_bgcolor',
            [
                'label' => esc_html__( 'Description Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'background-color:{{VALUE}};',
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details:before' => 'background-color:{{VALUE}};'
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_control( 'desc_brdcolor',
            [
                'label' => esc_html__( 'Description Border Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details' => 'border-color:{{VALUE}};',
                    '{{WRAPPER}} .electron-taxonomy-list .taxonomy-details:before' => 'border-color:{{VALUE}};'
                ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->add_control( 'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .taxonomy-desc' => 'color:{{VALUE}};' ],
                'condition' => ['desc' => 'yes']
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
        /*****   START CONTROLS SECTION   ******/
        $this->start_controls_section('navs_style_section',
            [
                'label'=> esc_html__( 'SLIDER NAV STYLE', 'electron' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['type' => 'slider','nav' => 'yes']
            ]
        );
        $this->add_control( 'navs_size',
            [
                'label' => esc_html__( 'Size', 'electron' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:after' => 'font-size:{{SIZE}}px;' ]
            ]
        );
        $this->add_control( 'navs_color',
            [
                'label' => esc_html__( 'Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrcolor',
            [
                'label' => esc_html__( 'Hover Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:hover:after,{{WRAPPER}} .electron-swiper-container .swiper-button-next:hover:after' => 'color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_bgcolor',
            [
                'label' => esc_html__( 'Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev,{{WRAPPER}} .electron-swiper-container .swiper-button-next' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->add_control( 'navs_hvrbgcolor',
            [
                'label' => esc_html__( 'Hover Background Color', 'electron' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => ['{{WRAPPER}} .electron-swiper-container .swiper-button-prev:hover,{{WRAPPER}} .electron-swiper-container .swiper-button-next:hover' => 'background-color:{{VALUE}};' ]
            ]
        );
        $this->end_controls_section();
        /*****   END CONTROLS SECTION   ******/
    }

    public function customImages($index) {
        $settings = $this->get_settings_for_display();

        $images = array();
        $type   = $settings['img_type'];
        $items  = 'icon' == $type ? $settings['icons'] : $settings['images'];
        $count  = 0;

        if ( 'icon' == $type ) {

            foreach ( $items as $item ) {
                if ( !empty( $item['icon']['value'] ) ) {
                    ob_start();
                    Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
                    $icon = ob_get_clean();
                    $images[$count] = '<span class="taxonomy-thumb elementor-repeater-item-'.$item['_id'].'">'.$icon.'</span>';
                }
                $icon = '';
                $count++;
            }

        } else {

            $mobsize = wp_is_mobile() ? 'mob_' : '';

            $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'thumbnail';
            if ( 'custom' == $size ) {
                $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
                $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
                $size  = [ $sizew, $sizeh ];
            }

            foreach ( $items as $item ) {
                if ( !empty( $item['image']['id'] ) ) {
                    $image = wp_get_attachment_image( $item['image']['id'], $size, false );
                    $images[$count] = '<div class="taxonomy-thumb">'.$image.'</div>';
                }
                $image = '';
                $count++;
            }
        }
        return !empty($images) && isset($images[$index]) ? $images[$index] : null;
    }

    protected function render() {

        $settings   = $this->get_settings_for_display();
        $id         = $this->get_id();
        $editmode   = \Elementor\Plugin::$instance->editor->is_edit_mode() ? '-'.$id: '';
        $mobsize    = wp_is_mobile() ? 'mob_' : '';
        $tax        = $settings['taxonomy'];
        $filter     = $settings['filter_type'];
        $show_image = $settings['show_image'];
        $img_type   = $settings['img_type'];
        $show_count = $settings['count'];
        $class      = $settings['style'];
        $class     .= ' img-type-'.$settings['img_type'];
        $class     .= ' layout-'.$settings['type'];
        $slide     = 'slider' == $settings['type'] ? ' swiper-slide' : '';

        $html = $deschtml = '';

        if ( $show_image == 'yes' ) {
            $size = $settings[$mobsize.'thumbnail_size'] ? $settings[$mobsize.'thumbnail_size'] : 'thumbnail';
            if ( 'custom' == $size ) {
                $sizew = $settings[$mobsize.'thumbnail_custom_dimension']['width'];
                $sizeh = $settings[$mobsize.'thumbnail_custom_dimension']['height'];
                $size  = [ $sizew, $sizeh ];
            }
        }

        if ( $tax == 'cat' ) {
            $taxonomy = array( 'taxonomy' => 'product_cat',$filter => $settings['cats']);
        } elseif ( $tax == 'tag' ) {
            $taxonomy = array( 'taxonomy' => 'product_tag',$filter => $settings['tags']);
        } elseif ( $tax == 'brand' ) {
			$electronOptions = get_option('electron');
			$brands1 = taxonomy_exists('electron_product_brands') ? 'electron_product_brands' : '';
			$brands2 = taxonomy_exists('product_brand') ? 'product_brand' : '';
			$brandsTax = isset($electronOptions['brands_visibility']) && $electronOptions['brands_visibility'] == 'yes' ? $brands1 : $brands2;
            $taxonomy = array( 'taxonomy' => $brandsTax,$filter => $settings['brands']);
        }

        $taxonomy['order']   = $settings['order'];
        $taxonomy['orderby'] = $settings['orderby'];
        $terms = get_terms($taxonomy);

        if ( !empty( $terms ) ) {

            $count = 0;
            foreach ( $terms as $term ) {
                if ( !empty( $term ) && !is_wp_error($term) ) {
                    $term_id    = $term->term_id;
                    $name       = $term->name;
                    $tcount     = $term->count;
                    $desc       = $term->description;
                    $count_html = 'yes' == $show_count && $tcount > 0 ? '<span class="taxonomy-count">'.$tcount.'</span>' : '';

                    $html .= '<div class="taxonomy-item'.$slide.'" data-id="'.$count.'">';
                        $html .= '<a class="taxonomy-link" href="'.esc_url( get_term_link( $term ) ).'" title="'.$name.'">';
                            if ( $show_image == 'yes' ) {
                                if ( $img_type == 'thumb' ) {
                                    $imgid = get_term_meta( $term_id, 'thumbnail_id', true );
                                    if ( $tax == 'brand' ) {
                                        if ( $brandsTax == 'electron_product_brands' ) {
                                            $meta = get_option( "taxonomy_$term_id" );
                                            $imgid  = !empty($meta['brand_thumbnail_id']) ? absint( $meta['brand_thumbnail_id'] ) : '';
                                        }
                                    }
                                    $image = $imgid ? wp_get_attachment_image( $imgid, $size, false ) : wc_placeholder_img('thumbnail');
                                    $html .= '<div class="taxonomy-thumb">'.$image.'</div>';
                                } elseif ( $img_type == 'img' || $img_type == 'icon' ) {
                                    $html .= $this->customImages($count);
                                }
                            }
                            $html .= '<span class="taxonomy-title" data-hover="'.$name.'"></span>';
                            $html .= $count_html;
                        $html .= '</a>';

                        if ( $desc && 'yes' == $settings['desc'] && 'slider' != $settings['type'] ) {
                            $html .= '<div class="taxonomy-details position-'.$settings['desc_position'].'"><p class="taxonomy-desc">'.$desc.'</p></div>';
                        }
                    $html .= '</div>';
                    $count++;
                }
            }
            if ( 'yes' == $settings['desc'] && 'slider' == $settings['type'] ) {
                $count2 = 0;
                foreach ( $terms as $term ) {
                    if ( !empty( $term ) && !is_wp_error($term) ) {
                        $desc = $term->description;
                        if ( $desc ) {
                            $deschtml .= '<div class="taxonomy-details position-'.$settings['desc_position'].'" data-id="'.$count2.'"><p class="taxonomy-desc">'.$desc.'</p></div>';
                        }
                        $count2++;
                    }
                }
            }
        }
        // final html
        if ( 'slider' == $settings['type'] ) {
            $slider_options = json_encode( array(
                "slidesPerView" => 1,
                "loop"          => 'yes' == $settings['loop'] ? true: false,
                "autoHeight"    => true,
                "rewind"        => true,
                "autoplay"      => 'yes' == $settings['autoplay'] ? [ "pauseOnMouseEnter" => true,"disableOnInteraction" => false ] : false,
                "wrapperClass"  => "electron-swiper-wrapper",
                "watchSlidesProgress"=> true,
                "speed"         => $settings['speed'],
                "spaceBetween"  => $settings['space'],
                "direction"     => "horizontal",
                "navigation" => [
                    "nextEl" => ".slide-next-$id",
                    "prevEl" => ".slide-prev-$id"
                ],
                "breakpoints" => [
                    "0" => [
                        "slidesPerView"  => $settings['xsitems'],
                        "slidesPerGroup" => $settings['xsitems'],
                    ],
                    "768" => [
                        "slidesPerView"  => $settings['smitems'],
                        "slidesPerGroup" => $settings['smitems']
                    ],
                    "1024" => [
                        "freeMode"       => false,
                        "slidesPerView"  => $settings['mditems'],
                        "slidesPerGroup" => $settings['mditems']
                    ]
                ]
            ));
            echo '<div class="electron-widget-taxonomy-wrapper '.$class.'">';
                echo '<div class="electron-taxonomy-list electron-products-widget-slider electron-swiper-container electron-swiper-slider'.$editmode.'" data-swiper-options=\''.$slider_options.'\'>';
                    echo '<div class="electron-swiper-wrapper">'.$html.'</div>';
                echo '</div>';
                if ( 'yes' == $settings['nav'] ) {
                    echo '<div class="electron-nav-wrapper">';
                    echo '<div class="electron-swiper-prev electron-nav-bg electron-nav-small slide-prev-'.$id.'"></div>';
                    echo '<div class="electron-swiper-next electron-nav-bg electron-nav-small slide-next-'.$id.'"></div>';
                    echo '</div>';
                }
            echo $deschtml;
            echo '</div>';

            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
                <script>
                jQuery( document ).ready( function($) {
                    const mySlider = new NTSwiper('.electron-swiper-slider-<?php echo $id; ?>', $('.electron-swiper-slider-<?php echo $id; ?>').data('swiper-options'));
                });
                </script>
                <?php
            }
        } else {
            echo '<div class="electron-widget-taxonomy-wrapper '.$class.'"><div class="electron-taxonomy-list">'.$html.'</div></div>';
        }
    }
}
