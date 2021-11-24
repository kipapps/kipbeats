<?php
//namespace RekordThemeEssential\Widgets;



if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Widget_Button_List extends Widget_Base {
    
    public function plugin_name() {
		return 'plugin-name';
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'btn-list';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Button List', $this->plugin_name() );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-code';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}
    
    /**
	 * Get button sizes.
	 *
	 * Retrieve an array of button sizes for the button widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array An array containing button sizes.
	 */
	public static function get_button_sizes() {
		return [
			'xs' => esc_html__( 'Extra Small', self::plugin_name() ),
			'sm' => esc_html__( 'Small', self::plugin_name() ),
			'md' => esc_html__( 'Medium', self::plugin_name() ),
			'lg' => esc_html__( 'Large', self::plugin_name() ),
			'xl' => esc_html__( 'Extra Large', self::plugin_name() ),
		];
	}
    
	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', $this->plugin_name() ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'button_type',
			[
				'label' => esc_html__( 'Type', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'Default', $this->plugin_name() ),
					'info' => esc_html__( 'Info', $this->plugin_name() ),
					'success' => esc_html__( 'Success', $this->plugin_name() ),
					'warning' => esc_html__( 'Warning', $this->plugin_name() ),
					'danger' => esc_html__( 'Danger', $this->plugin_name() ),
				],
				'prefix_class' => 'elementor-button-',
			]
		);
        $repeater = new \Elementor\Repeater();
        

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Click here', $this->plugin_name() ),
				'placeholder' => esc_html__( 'Click here', $this->plugin_name() ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', $this->plugin_name() ),
				'default' => [
					'url' => '#',
				],
			]
		);
        $repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin' => 'inline',
				'label_block' => false,
			]
		);

		
        
        
        $this->add_control(
           'btn-list',
           [
               'label' => __( 'Button List', $this->plugin_name() ),
               'type' => \Elementor\Controls_Manager::REPEATER,
               'fields' => $repeater->get_controls(),
               'default' => [
                   [
                       'text' => __( 'Title #1', $this->plugin_name() ),
                       //'list_content' => __( 'Item content. Click the edit button to change this text.', $this->plugin_name() ),
                   ],
                   
               ],
               'title_field' => '{{{ text }}}',
           ]
        );
        
        $this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', $this->plugin_name() ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', $this->plugin_name() ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', $this->plugin_name() ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', $this->plugin_name() ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);
        
        $this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);
        
        $this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', $this->plugin_name() ),
					'right' => esc_html__( 'After', $this->plugin_name() ),
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label' => esc_html__( 'Button ID', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', $this->plugin_name() ),
				'description' => sprintf(
					/* translators: 1: Code open tag, 2: Code close tag. */
					esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows %1$sA-z 0-9%2$s & underscore chars without spaces.', $this->plugin_name() ),
					'<code>',
					'</code>'
				),
				'separator' => 'before',

			]
		);
        

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_btn_list',
			[
				'label' => esc_html__( 'Button', $this->plugin_name() ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-btn-list-items:not(.elementor-inline-items) .elementor-btn-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-btn-list-items:not(.elementor-inline-items) .elementor-btn-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-btn-list-items.elementor-inline-items .elementor-btn-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-btn-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-btn-list-items.elementor-inline-items .elementor-btn-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-btn-list-items.elementor-inline-items .elementor-btn-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_responsive_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', $this->plugin_name() ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', $this->plugin_name() ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', $this->plugin_name() ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', $this->plugin_name() ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
                'separator' => 'after',
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-button',
                
			]
		);
        
        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);
        
        $this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', $this->plugin_name() ),
			]
		);
        $this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', $this->plugin_name() ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Background', $this->plugin_name()  ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-button',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
					],
				],
			]
		);

		$this->end_controls_tab();
        $this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', $this->plugin_name() ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => esc_html__( 'Text Color', $this->plugin_name() ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'label' => esc_html__( 'Background', $this->plugin_name() ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', $this->plugin_name() ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', $this->plugin_name() ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', $this->plugin_name() ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', $this->plugin_name() ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);


        $this->end_controls_section();
        
        

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'btn_list', 'class', 'elementor-btn-list-items' );
        $this->add_render_attribute( 'list_item', 'class', 'elementor-btn-list-item' );
        //print_r($settings);
    ?>

		<div <?php $this->print_render_attribute_string( 'btn_list' ); ?>>
     <?php foreach ( $settings['btn-list'] as $index => $item ) :
        $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'btn_list', $index );
        $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-btn-list-text' );
        $this->add_inline_editing_attributes( $repeater_setting_key );
        $migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
        //print_r($repeater_setting_key);
        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper elementor-btn-list-item' );
        
        if ( ! empty( $item['link']['url'] ) ) {
            $link_key = 'link_' . $index;//'button'
			$this->add_link_attributes( 'button'.$index, $item['link'] );
			$this->add_render_attribute( 'button'.$index, 'class', 'elementor-button-link' );
		}
                
		$this->add_render_attribute( 'button'.$index, 'class', 'elementor-button' );
		$this->add_render_attribute( 'button'.$index, 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button'.$index, 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button'.$index, 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button'.$index, 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
        
        ?> 
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<a <?php $this->print_render_attribute_string( 'button'.$index ); ?>>
				<?php $this->render_text($index); ?>
			</a>
		</div>
        
          
        
        <?php endforeach; ?>
		</div>
		<?php //print_r( $item ); ?>

		
        <?php 
	}
    
    
    
    protected function render_text($index=0) {
		$settings = $this->get_settings_for_display();
        $btn = $settings['btn-list'][$index];
        //print_r($btn['text']);
		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && \Elementor\Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['icon_align'] ) ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			//old default
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php $this->print_render_attribute_string( 'content-wrapper' ); ?>>
			<?php if ( ! empty( $btn['icon'] ) || ! empty( $btn['selected_icon']['value'] ) ) : ?>
			<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
				<?php if ( $is_new || $migrated ) :
					\Elementor\Icons_Manager::render_icon( $btn['selected_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<span <?php $this->print_render_attribute_string( 'text' ); ?>><?= $btn['text'] ?></span>
		</span>
		<?php
	}

}