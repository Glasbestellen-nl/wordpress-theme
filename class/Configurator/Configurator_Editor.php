<?php
namespace Configurator;

class Rule {
    protected $_type;
}

class Option {
    protected $_title;
    protected $_price;
    protected $_rules = [];
}

class Configurator_Editor {

    protected $_id;

    protected $_settings = [];

    public function __construct( int $configurator_id ) {
        $this->_id = $configurator_id;
        $this->_settings = get_post_meta( $configurator_id, 'configurator_settings', true );
    }

    public function add_option( string $step_id, Option $option ) {
        $step = $this->get_step_by_id( $step_id );
        if ( ! $step ) return;
        $step_options = $step['options'];
        $step_options = [
            'title'   => $option->get_title(),
            'price'   => $option->get_price(),
            'default' => $option->get_default(),
        ];

        $rules = $option->get_rules();
        if ( $rules ) {
            foreach ( $rules as $rule ) {
                if ( 'exclude' == $rule->get_type() ) {
                    $step_options['rules']['exclude'][] = [
                        'step'    => $rule->get_step_id(),
                        'options' => $rule->get_options(),
                    ];
                    $other_step = $this->get_step_by_id( $rule->get_step_id() );
                    if ( $other_step ) {
                        foreach ( $rule->get_options() as $option_id ) {
                            $other_step['options'][]['rules']['exclude'] = [
                                'step' => $step_id,
                                'options' => [],
                            ]; 
                        }
                    }
                }
            }
        }
    }

    public function get_step_index_by_id( string $step_id ) {

    }

    public function get_step_by_id() {
        $index = $this->get_step_index_by_id( $step_id );
        return ! empty( $this->_settings['steps'][$index] ) ? $this->_settings['steps'][$index] : false;
    }

}

$configurator_editor = new Configurator_Editor( $configurator_id );
$rules = [
    new Rule( 'exclude', 'sensor_switch', [1, 4, 5], 'Message' )
]; 
$option = new Option( 'Multicolor (RGB) met afstandsbediening', 73.55, $rules );
$configurator_editor->add_option( 'light_color', $option );