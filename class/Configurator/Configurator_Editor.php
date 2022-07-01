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
        $step_index = get_step_index_by_id( $step_id );
        $step = $this->get_step_by_id( $step_id );
        if ( ! $step ) return;
        $option_id = $this->generate_next_option_id( $step_id );
        $step['options'] = [
            'id'      => $option_id,
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
                        'message' => sprintf( 'De combinatie %s en de keuze in stap %s is niet mogelijk. Verander a.u.b. een van de keuzes.', $option->get_title(), $this->get_step_title_by_id() )
                    ];
                    $other_step = $this->get_step_by_id( $rule->get_step_id() );
                    if ( $other_step ) {
                        foreach ( $rule->get_options() as $option_id ) {
                            $option_index = $this->get_option_index_by_id( $rule->get_step_id(), $option_id );
                            $other_step['options'][$option_index]['rules']['exclude'] = [
                                'step' => $step_id,
                                'options' => [],
                            ]; 
                        }
                    }
                }
            }
        }
        $this->_settings['steps'][$step_index] = $step;
        return true;
    }

    public function get_step_index_by_id( string $step_id ) {
        $steps = $this->_settings['steps'];
        if ( empty( $steps ) ) return;
        $step_index = false;
        foreach ( $steps as $index => $step ) {
            if ( $step['id'] == $step_id ) 
                $step_index = $index;
        }
        return $index;
    }

    public function get_step_by_id( string $step_id ) {
        $index = $this->get_step_index_by_id( $step_id );
        return ! empty( $this->_settings['steps'][$index] ) ? $this->_settings['steps'][$index] : false;
    }

    public function get_step_title_by_id( string $step_id ) {
        $step = $this->get_step_by_id( $step_id );
        return ! empty( $step['title'] ) ? $step['title'] : false;
    }

    public function generate_next_option_id( string $step_id ) {
        $step = $this->get_step_by_id( $step_id );
        if ( ! $step || empty( $step['options'] ) ) return;
        $next_id = 0;
        foreach ( $step['options'] as $option ) {
            if ( $option['id'] >= $next_id ) 
                $next_id = $option['id'];
        }
        return $next_id + 1;
    }

    public function get_option_index_by_id( string $step_id, $option_id ) {
        $step = $this->get_step_by_id( $step_id );
        if ( ! $step || empty( $step['options'] ) ) return;
        $option_index = false;
        foreach ( $step['options'] as $index => $option ) {
            if ( $option['id'] == $option_id ) 
                $option_index = $index;
        }
        return $option_index;
    }

}

$configurator_editor = new Configurator_Editor( $configurator_id );
$rules = [
    new Rule( 'exclude', 'sensor_switch', [1, 4, 5], 'Message' )
]; 
$option = new Option( 'Multicolor (RGB) met afstandsbediening', 73.55, $rules );
$configurator_editor->add_option( 'light_color', $option );