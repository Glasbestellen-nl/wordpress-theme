<?php
class Tracking {

    private static $instance;

    public function __construct() {
        add_action('gb_top_of_head', [$this, 'add_enhanced_user_data_to_head']);
    }

    public function add_enhanced_user_data_to_head() {

        // Get current page id
        $current_page_id = (int) get_queried_object_id();
        if (empty($current_page_id)) {
            return;
        }

        // Get lead success page id
        $lead_success_page_id = (int) get_option('page_lead_success');
        if (empty($lead_success_page_id)) {
            return;
        }

        // Only add data to head if current page is the lead success page
        if ($current_page_id !== $lead_success_page_id) {
            return;
        }

        // Get lead id from query string
        if (empty($_GET['lid'])) {
            return;
        }

        // Get lead data by id
        $lead = CRM::get_lead($_GET['lid']);
        if (empty($lead)) {
            return;
        }

        // Get relation data from lead
        $relation = $lead->get_relation();
        if (empty($relation)) {
            return;
        }

        $email = $relation->get_email();
        $full_name = $relation->get_name();
        $name_parts = explode(' ', $full_name);
        $first_name = $name_parts[0];
        $last_name = implode(' ', array_slice($name_parts, 1));
        $phone = $relation->get_phone();
        $city = $relation->get_residence();
        ?>

        <script>
            var dataLayer = window.dataLayer || [];
            dataLayer.push({
                'lead.user.email': '<?php echo $email; ?>',
                'lead.user.firstName': '<?php echo $first_name; ?>',
                'lead.user.lastName': '<?php echo $last_name; ?>',
                'lead.user.phone': '<?php echo $phone; ?>',
                'lead.user.city': '<?php echo $city; ?>'
            });
        </script>

        <?php 

    }

    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}
Tracking::get_instance();