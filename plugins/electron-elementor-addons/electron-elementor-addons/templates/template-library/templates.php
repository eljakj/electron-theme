<?php
/**
 * Template library templates
 */

defined( 'ABSPATH' ) || exit;
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'masonry' );
?>
<script type="text/template" id="tmpl-electronTemplateLibrary__header-logo">
    <span class="electronTemplateLibrary__logo-wrap">
		<i class="electron electron-addons"></i>
	</span>
    <span class="electronTemplateLibrary__logo-title">NINETHEME {{{ title }}}</span>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo __( 'Back to Library', 'electron' ); ?></span>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__header-menu">
	<# _.each( tabs, function( args, tab ) { var activeClass = args.active ? 'elementor-active' : ''; #>
		<div class="elementor-component-tab elementor-template-library-menu-item {{activeClass}}" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__header-menu-responsive">
	<div class="elementor-component-tab electronTemplateLibrary__responsive-menu-item elementor-active" data-tab="desktop">
		<i class="eicon-device-desktop" aria-hidden="true" title="<?php esc_attr_e( 'Desktop view', 'electron' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Desktop view', 'electron' ); ?></span>
	</div>
	<div class="elementor-component-tab electronTemplateLibrary__responsive-menu-item" data-tab="tab">
		<i class="eicon-device-tablet" aria-hidden="true" title="<?php esc_attr_e( 'Tab view', 'electron' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Tab view', 'electron' ); ?></span>
	</div>
	<div class="elementor-component-tab electronTemplateLibrary__responsive-menu-item" data-tab="mobile">
		<i class="eicon-device-mobile" aria-hidden="true" title="<?php esc_attr_e( 'Mobile view', 'electron' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Mobile view', 'electron' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__header-actions">
	<div id="electronTemplateLibrary__header-sync" class="elementor-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Library', 'electron' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Sync Library', 'electron' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__preview">
    <iframe></iframe>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__header-insert">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ electron.library.getModal().getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__insert-button">
	<a class="elementor-template-library-template-action elementor-button electronTemplateLibrary__insert-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'electron' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div>
		</div>
		<div class="elementor-loading-title"><?php esc_html_e( 'Loading', 'electron' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__templates">
	<div id="electronTemplateLibrary__toolbar">
		<div id="electronTemplateLibrary__toolbar-filter" class="electronTemplateLibrary__toolbar-filter">
			<# if (electron.library.getTypeTags()) { var selectedTag = electron.library.getFilter( 'tags' ); #>
				<# if ( selectedTag ) { #>
				<span class="electronTemplateLibrary__filter-btn">{{{ electron.library.getTags()[selectedTag] }}} <i class="eicon-caret-right"></i></span>
				<# } else { #>
				<span class="electronTemplateLibrary__filter-btn"><?php esc_html_e( 'Filter', 'electron' ); ?> <i class="eicon-caret-right"></i></span>
				<# } #>
				<ul id="electronTemplateLibrary__filter-tags" class="electronTemplateLibrary__filter-tags">
					<li data-tag="">All</li>
					<# _.each(electron.library.getTypeTags(), function(slug) {
						var selected = selectedTag === slug ? 'active' : '';
						#>
						<li data-tag="{{ slug }}" class="{{ selected }}">{{{ electron.library.getTags()[slug] }}}</li>
					<# } ); #>
				</ul>
			<# } #>
		</div>
		<div id="electronTemplateLibrary__toolbar-counter"></div>
		<div id="electronTemplateLibrary__toolbar-search">
			<label for="electronTemplateLibrary__search" class="elementor-screen-only"><?php esc_html_e( 'Search Templates:', 'electron' ); ?></label>
			<input id="electronTemplateLibrary__search" placeholder="<?php esc_attr_e( 'Search', 'electron' ); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>

	<div class="electronTemplateLibrary__templates-window">
		<div id="electronTemplateLibrary__templates-list"></div>
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__template">
	<div class="electronTemplateLibrary__template-body elementor-template-library-template-body" data-col="template-col-{{ col }}" id="electronTemplate-{{ template_id }}">

		<div class="electronTemplateLibrary__template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
        <img class="electronTemplateLibrary__template-thumbnail" src="{{ thumbnail }}">
        <div class="electronTemplateLibrary__template-name">{{ title }}</div>
	</div>
	<div class="electronTemplateLibrary__template-footer">
		{{{ electron.library.getModal().getTemplateActionButton( obj ) }}}

		<a href="#" class="elementor-button electronTemplateLibrary__preview-button">
			<i class="eicon-device-desktop" aria-hidden="true"></i>
			<?php esc_html_e( 'Preview', 'electron' ); ?>
		</a>
	</div>
</script>

<script type="text/template" id="tmpl-electronTemplateLibrary__empty">

	<div class="elementor-template-library-blank-icon">
		<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/no-search-results.svg'; ?>" class="elementor-template-library-no-results" />
	</div>
	<div class="elementor-template-library-blank-title"></div>
	<div class="elementor-template-library-blank-message"></div>
	<div class="elementor-template-library-blank-footer">
		<?php esc_html_e( 'Want to learn more about the Electron Library?', 'electron' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="https://ninetheme.com/themes/electron/fashion/" target="_blank"><?php echo __( 'Click here', 'electron' ); ?></a>
	</div>
</script>
