<?php
if (!class_exists('EduCenter_Welcome')) :

    class EduCenter_Welcome
    {

        public $tab_sections = array();
        public $theme_name = ''; // For storing Theme Name
        public $theme_version = ''; // For Storing Theme Current Version Information
        public $free_plugins = array(); // For Storing the list of the Recommended Free Plugins

        /**
         * Constructor for the Welcome Screen
         */

        public function __construct()
        {

            /** Useful Variables */
            $theme = wp_get_theme();
            $this->theme_name = $theme->Name;
            $this->theme_version = $theme->Version;

            /** Define Tabs Sections */
            $this->tab_sections = array(
                'getting_started' => esc_html__('Getting Started', 'educenter'),
                'recommended_plugins' => esc_html__('Recommended Plugins', 'educenter'),
                'support' => esc_html__('Support', 'educenter'),
                'free_vs_pro' => esc_html__('Free Vs Pro', 'educenter')
            );

            /** List of Recommended Free Plugins */
            /** List of Recommended Free Plugins **/
            $this->free_plugins = array(
                'learnpress' => array(
                    'name' => 'LearnPress – WordPress LMS Plugin',
                    'slug' => 'learnpress',
                    'filename' => 'learnpress',
                    'thumb_path' => 'https://ps.w.org/learnpress/assets/icon-256x256.png?rev=2403692'
                ),
                'wp-events-manager' => array(
                    'name' => 'WP Events Manager',
                    'slug' => 'wp-events-manager',
                    'filename' => 'wp-events-manager',
                    'thumb_path' => 'https://ps.w.org/wp-events-manager/assets/icon-256x256.png'
                ),

                'elementor' => array(
                    'name' => 'Elementor Website Builder',
                    'slug' => 'elementor',
                    'filename' => 'elementor',
                    'thumb_path' => 'https://ps.w.org/elementor/assets/icon-256x256.gif'
                ),

                'contact-form-7' => array(
                    'name' => 'Contact Form 7',
                    'slug' => 'contact-form-7',
                    'filename' => 'contact-form-7',
                    'thumb_path' => 'https://ps.w.org/contact-form-7/assets/icon-256x256.png?rev=2279696'
                ),

                'woocommerce' => array(
                    'name' => 'WooCommerce',
                    'slug' => 'woocommerce',
                    'filename' => 'woocommerce',
                    'thumb_path' => 'https://ps.w.org/woocommerce/assets/icon-256x256.gif?rev=2869506'
                ),


                'loco-translate' => array(
                    'name' => 'Loco Translate',
                    'slug' => 'loco-translate',
                    'filename' => 'loco-translate',
                    'thumb_path' => 'https://ps.w.org/loco-translate/assets/icon-256x256.png?rev=1000676'
                ),

                'patterns-kit' => array(
                    'name' => 'Patterns Kit',
                    'slug' => 'patterns-kit',
                    'filename' => 'plugins',
                    'thumb_path' => 'https://ps.w.org/patterns-kit/assets/icon-256x256.png?rev=2429976'
                ),

                'polylang' => array(
                    'name' => 'Polylang',
                    'slug' => 'polylang',
                    'filename' => 'polylang',
                    'thumb_path' => 'https://ps.w.org/polylang/assets/icon-256x256.png?rev=1331499'
                ),

            );

            /* Create a Welcome Page */
            add_action('admin_menu', array($this, 'welcome_register_menu'));

            /* Enqueue Styles & Scripts for Welcome Page */
            add_action('admin_enqueue_scripts', array($this, 'welcome_styles_and_scripts'));

            /* Adds Footer Rating Text */
            add_filter('admin_footer_text', array($this, 'admin_footer_text'));

            /* Hide Notice */
            add_filter('wp_loaded', array($this, 'hide_admin_notice'), 10);

            /* Create a Welcome Page */
            add_action('wp_loaded', array($this, 'admin_notice'), 20);

            add_action('after_switch_theme', array($this, 'erase_hide_notice'));

            add_action('wp_ajax_educenter_activate_plugin', array($this, 'activate_plugin'));
        }

        /** Trigger Welcome Message Notification */
        public function admin_notice($hook)
        {
            $hide_notice = get_option('educenter_hide_notice');
            if (!$hide_notice) {
                add_action('admin_notices', array($this, 'admin_notice_content'));
            }
        }

        /** Welcome Message Notification */
        public function admin_notice_content()
        {
            $screen = get_current_screen();

            if ('appearance_page_educenter-welcome' === $screen->id || (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) || 'theme-install' === $screen->id) {
                return;
            }

            $slug = $filename = 'one-click-demo-import';
            ?>
            <div class="updated notice educenter-welcome-notice">
                <div class="educenter-welcome-notice-wrap">
                    <h2><?php esc_html_e('Congratulations!', 'educenter'); ?></h2>
                    <p><?php printf(esc_html__('%1$s is now installed and ready to use. You can start either by importing the ready made demo or get started by customizing it your self.', 'educenter'), $this->theme_name); ?></p>

                    <div class="educenter-welcome-info">
                        <div class="educenter-welcome-thumb">
                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/screenshot.png'); ?>" alt="<?php echo esc_attr__('EduCenter Demo', 'educenter'); ?>">
                        </div>

                        <?php
                        if ('appearance_page_sparkle-theme-demo-importer' !== $screen->id) {
                            ?>
                            <div class="educenter-welcome-import">
                                <h3><?php esc_html_e('Import Demo', 'educenter'); ?></h3>
                                <p><?php esc_html_e('Click below to install and active One Click Demo Importer Plugin, It\'s help you to import demo.', 'educenter'); ?></p>
                                <p><?php echo $this->generate_demo_installer_button(); ?></p>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="educenter-welcome-getting-started">
                            <h3><?php esc_html_e('Get Started', 'educenter'); ?></h3>
                            <p><?php printf(esc_html__('Here you will find all the necessary links and information on how to use %s.', 'educenter'), $this->theme_name); ?></p>
                            <p><a href="<?php echo esc_url(admin_url('admin.php?page=educenter-welcome')); ?>" class="button button-primary"><?php esc_html_e('Go to Setting Page', 'educenter'); ?></a></p>
                        </div>
                    </div>

                    <a href="<?php echo wp_nonce_url(add_query_arg('educenter_hide_notice', 1), 'educenter_hide_notice_nonce', '_educenter_notice_nonce'); ?>" class="notice-close"><?php esc_html_e('Dismiss', 'educenter'); ?></a>
                </div>

            </div>
            <?php
        }

        /** Hide Admin Notice */
        public function hide_admin_notice()
        {
            if (isset($_GET['educenter_hide_notice']) && isset($_GET['_educenter_notice_nonce']) && current_user_can('manage_options')) {
                if (!wp_verify_nonce(wp_unslash($_GET['_educenter_notice_nonce']), 'educenter_hide_notice_nonce')) {
                    wp_die(esc_html__('Action Failed. Something is Wrong.', 'educenter'));
                }

                update_option('educenter_hide_notice', true);
            }
        }

        /** Register Menu for Welcome Page */
        public function welcome_register_menu()
        {
            add_menu_page(esc_html__('Welcome', 'educenter'), sprintf(esc_html__('%s', 'educenter'), esc_html(str_replace(' ', '', $this->theme_name))), 'manage_options', 'educenter-welcome', array($this, 'welcome_screen'), 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjE5MiIgaGVpZ2h0PSIxOTIiPgo8cGF0aCBkPSJNMCAwIEMzLjg5NzQ0MDQxIDIuNTk4MjkzNjEgNC40MDc1OTc5OSA1LjQ2Njk1MTc4IDUuNjk5MjE4NzUgOS43NDYwOTM3NSBDNS45MzkxMzA0IDEwLjUxMzAxMDQxIDYuMTc5MDQyMDUgMTEuMjc5OTI3MDYgNi40MjYyMjM3NSAxMi4wNzAwODM2MiBDNi45MzEyMzQ3NiAxMy42OTE3MTU3NSA3LjQzMTA0MjE1IDE1LjMxNDk3NjIyIDcuOTI2MDI1MzkgMTYuOTM5Njk3MjcgQzguNjg0NTI0OTggMTkuNDI3NzQxMjcgOS40NTg5NjIyMyAyMS45MTAzNzE3OSAxMC4yMzYzMjgxMiAyNC4zOTI1NzgxMiBDMTAuNzI0OTAyNTIgMjUuOTY4NDU3NTggMTEuMjEyNTYzNjEgMjcuNTQ0NjIwNTQgMTEuNjk5MjE4NzUgMjkuMTIxMDkzNzUgQzExLjkzMDQxOTE2IDI5Ljg2NDkxODA2IDEyLjE2MTYxOTU3IDMwLjYwODc0MjM3IDEyLjM5OTgyNjA1IDMxLjM3NTEwNjgxIEMxMy4zMDM5MDk2NSAzNC4zNTUzNDE1MyAxNCAzNi44NjY4OTEzOSAxNCA0MCBDMjguNTIgNDAgNDMuMDQgNDAgNTggNDAgQzU2Ljg0MTc1NzYyIDQ0LjYzMjk2OTUzIDU2LjIyMTExMDYzIDQ0LjkyODcyMzYzIDUyLjQzNzUgNDcuNSBDNTEuNDU1MjM0MzggNDguMTg0NDkyMTkgNTAuNDcyOTY4NzUgNDguODY4OTg0MzcgNDkuNDYwOTM3NSA0OS41NzQyMTg3NSBDNDguOTE0MDUyNzMgNDkuOTUzNjg2NTIgNDguMzY3MTY3OTcgNTAuMzMzMTU0MyA0Ny44MDM3MTA5NCA1MC43MjQxMjEwOSBDNDQuMzM0Mzk1OTYgNTMuMTc4MTg3MTYgNDAuOTU0OTEyNjYgNTUuNzUzNzY2NjUgMzcuNTYyNSA1OC4zMTI1IEMzNS41OTA3ODAwMyA1OS43OTQ4MjIwOCAzMy42MTg5OTYxNyA2MS4yNzcwMzE4MyAzMS42NDUwMTk1MyA2Mi43NTYzNDc2NiBDMzAuMzAxMDkxODYgNjMuNzcyMzcxMzQgMjguOTc0MTI2NTUgNjQuODEwNzk4NDkgMjcuNjUyMzQzNzUgNjUuODU1NDY4NzUgQzI2IDY3IDI2IDY3IDI0IDY3IEMyNC4zMjYxMzI4MSA2OC4wMjczODI4MSAyNC42NTIyNjU2MiA2OS4wNTQ3NjU2MyAyNC45ODgyODEyNSA3MC4xMTMyODEyNSBDMjUuNDMwMTgzNTEgNzEuNTEyODY0MzIgMjUuODcxNTUyMTggNzIuOTEyNjE1OTMgMjYuMzEyNSA3NC4zMTI1IEMyNi41NDMyNDIxOSA3NS4wNDQzNjUyMyAyNi43NzM5ODQzNyA3NS43NzYyMzA0NyAyNy4wMTE3MTg3NSA3Ni41MzAyNzM0NCBDMjguMjc4NzY5MTggODAuNTgyMzQzNDMgMjkuNDU0MzY4NjEgODQuNjMzOTU5NjkgMzAuNSA4OC43NSBDMzEuODM0MDgwMzIgOTMuODc2OTAxNjkgMzMuODg1MTE1NTIgOTguNTcxMDM5NTMgMzYuMTA5Mzc1IDEwMy4zNzEwOTM3NSBDMzcuMDUxNjMxMDYgMTA2LjE1MjQwMjIxIDM3LjA0NDE2NTM5IDEwNy4zMDY4MTczMSAzNiAxMTAgQzMzLjExOTYzNjU0IDEwOC42MjgwMzMxNSAzMC41MDkxMTExMSAxMDcuMDc1MjMzOTMgMjcuODc1IDEwNS4yNzczNDM3NSBDMjcuMDkxMDA4MyAxMDQuNzQyNjI0NTEgMjYuMzA3MDE2NiAxMDQuMjA3OTA1MjcgMjUuNDk5MjY3NTggMTAzLjY1Njk4MjQyIEMyNC42NzQ1MDkyOCAxMDMuMDg5NTUzMjIgMjMuODQ5NzUwOTggMTAyLjUyMjEyNDAyIDIzIDEwMS45Mzc1IEMyMi4xNTY1NTAyOSAxMDEuMzU5MTEzNzcgMjEuMzEzMTAwNTkgMTAwLjc4MDcyNzU0IDIwLjQ0NDA5MTggMTAwLjE4NDgxNDQ1IEMxMy44MjkxNzk1NSA5NS42MjQ3ODc2IDcuMzU4MjEwMzMgOTAuOTExNDMxOTMgMSA4NiBDLTQuNjU4MjMyODMgODguOTU3NzEyNjEgLTkuNTc3NDc4OTUgOTIuNjIwNTg5MzUgLTE0LjY2MDE1NjI1IDk2LjQ3MjY1NjI1IEMtMTguMjUzOTc5NyA5OS4xOTYyOTQxIC0yMS44NjE4NzQ0IDEwMS44OTgyNjY3NiAtMjUuNSAxMDQuNTYyNSBDLTI2LjA4NzI0ODU0IDEwNS4wMDQxNjUwNCAtMjYuNjc0NDk3MDcgMTA1LjQ0NTgzMDA4IC0yNy4yNzk1NDEwMiAxMDUuOTAwODc4OTEgQy0zMC41NzA5NzgxOSAxMDguMjkzNjk5OTggLTMxLjc5MDYwMzUzIDEwOSAtMzYgMTA5IEMtMzQuODc0NjA5MjUgMTAzLjI3OTI2MzcxIC0zMy4zNDMxMTY1OCA5OC4wMzk5MTExOCAtMzEuMjg1MTU2MjUgOTIuNTkzNzUgQy0yOC4yNjYyODg2NyA4NC4xNTE5MzE4NSAtMjUuNjg0NjA3NSA3NS41NTI5NDIyMSAtMjMgNjcgQy0yNC4xNDc0NjcwNCA2Ni41NzAwMTcwOSAtMjQuMTQ3NDY3MDQgNjYuNTcwMDE3MDkgLTI1LjMxODExNTIzIDY2LjEzMTM0NzY2IEMtMjguNjY3MDQ1MjUgNjQuNzE4NjA4MzEgLTMxLjI2MDU3MzYxIDYyLjYzNzUzODU2IC0zNC4wNjI1IDYwLjM3NSBDLTM5LjMxNTY4NTQ5IDU2LjIxODQ5MjQ2IC00NC42ODA2MDI3MSA1Mi40NzI4NjAxIC01MC4zNDM3NSA0OC44ODY3MTg3NSBDLTUzLjIyMTkwMjYgNDYuODQyMzgzODkgLTU1LjU3MjA5Nzk0IDQ0LjU1NTQ1NDg4IC01OCA0MiBDLTU3LjY3IDQxLjM0IC01Ny4zNCA0MC42OCAtNTcgNDAgQy00Mi44MSAzOS42NyAtMjguNjIgMzkuMzQgLTE0IDM5IEMtMTAuODM4MzcxMDEgMjguNzQwNzc3OTEgLTEwLjgzODM3MTAxIDI4Ljc0MDc3NzkxIC03LjY4ODIzMjQyIDE4LjQ3ODAyNzM0IEMtNy4yODYwNTYwNyAxNy4xODA1MzY0MyAtNi44ODM0OTMzOCAxNS44ODMxNjUxNyAtNi40ODA0Njg3NSAxNC41ODU5Mzc1IEMtNi4xNzk2MTM2NSAxMy41OTU1NzQ5NSAtNi4xNzk2MTM2NSAxMy41OTU1NzQ5NSAtNS44NzI2ODA2NiAxMi41ODUyMDUwOCBDLTIuODI0NTA3NTEgMi44MjQ1MDc1MSAtMi44MjQ1MDc1MSAyLjgyNDUwNzUxIDAgMCBaICIgZmlsbD0iIzVBMjJDNiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOTYsMzcpIi8+CjxwYXRoIGQ9Ik0wIDAgQzAuODQ3NDg4MSAwLjAwMDQ4MzQgMS42OTQ5NzYyIDAuMDAwOTY2OCAyLjU2ODE0NTc1IDAuMDAxNDY0ODQgQzE1LjczMjA3MzAzIDAuMDUzNzcyNDYgMjcuNTA1Nzg4MDkgMS4wMTg2MzY4MSAzOS42MjUgNi41NjI1IEM0MC42MTIzNDEzMSA2Ljk4ODEzMjMyIDQwLjYxMjM0MTMxIDYuOTg4MTMyMzIgNDEuNjE5NjI4OTEgNy40MjIzNjMyOCBDNjEuNjYwNzAxNTMgMTYuMjMzNjUzNDggNzkuMjAwOTE4MDUgMzIuODI4ODUxODggODguNjI1IDUyLjU2MjUgQzg4Ljk4ODUxNTYyIDUzLjIyMjUgODkuMzUyMDMxMjUgNTMuODgyNSA4OS43MjY1NjI1IDU0LjU2MjUgQzk2LjEzMTQ3OTA4IDY2LjI5NjY5ODMxIDk3LjE4ODA3OTE3IDc3LjUwMjE5MTU0IDk2LjYyNSA5MC41NjI1IEM5My4zMjUgOTAuNTYyNSA5MC4wMjUgOTAuNTYyNSA4Ni42MjUgOTAuNTYyNSBDODYuMzgyNjU2MjUgODkuMjk1MzUxNTYgODYuMTQwMzEyNSA4OC4wMjgyMDMxMyA4NS44OTA2MjUgODYuNzIyNjU2MjUgQzg1LjIwODA1MzEgODMuMjUwNDcyNjYgODQuNDk3NTcxNDMgNzkuNzg2MDc4OTUgODMuNzQ2MDkzNzUgNzYuMzI4MTI1IEM4My41NzI2MzQyOCA3NS41MjkyMjg1MiA4My4zOTkxNzQ4IDc0LjczMDMzMjAzIDgzLjIyMDQ1ODk4IDczLjkwNzIyNjU2IEM4Mi4xODA3OTA4MiA2OS44MTMzNDY2NiA4MC42OTAwNzMwNSA2Ni4yMzUwNzg4OSA3OC42MjUgNjIuNTYyNSBDNzguMjg3NDI2NzYgNjEuOTUyNDUxMTcgNzcuOTQ5ODUzNTIgNjEuMzQyNDAyMzQgNzcuNjAyMDUwNzggNjAuNzEzODY3MTkgQzc1LjY0MjMyMTIyIDU3LjE3MzY1NzM3IDczLjY1OTY2MDE1IDUzLjY0NzkyMzEyIDcxLjY0ODQzNzUgNTAuMTM2NzE4NzUgQzcwLjIyNjQwNjEgNDcuNjQ3MTk4NjEgNjguODYyNDYzMTcgNDUuMTUwNTI3ODIgNjcuNjI1IDQyLjU2MjUgQzY2Ljk2NSA0Mi41NjI1IDY2LjMwNSA0Mi41NjI1IDY1LjYyNSA0Mi41NjI1IEM2My45MTM5MTMxMSA0MC45NDE0NzAzMiA2Mi4yNTI0NjY5NCAzOS4yNjc0NjUzNyA2MC42MjUgMzcuNTYyNSBDNTkuODYxODc1IDM2Ljg0MDYyNSA1OS4wOTg3NSAzNi4xMTg3NSA1OC4zMTI1IDM1LjM3NSBDNTYuNjI1IDMzLjU2MjUgNTYuNjI1IDMzLjU2MjUgNTYuNjI1IDMxLjU2MjUgQzU2LjA5MTMyODEyIDMxLjMxMTEzMjgxIDU1LjU1NzY1NjI1IDMxLjA1OTc2NTYzIDU1LjAwNzgxMjUgMzAuODAwNzgxMjUgQzUyLjA2NTM0MzA3IDI5LjI3MTY2MTg5IDQ5LjMwNTU0ODM3IDI3LjUxNzgzMzQ5IDQ2LjUgMjUuNzUgQzQ0LjIxNDQzOTMyIDI0LjM0Mzc5NDI2IDQxLjkyMDQ0NjU0IDIyLjk1MjYyNDU2IDM5LjYyNSAyMS41NjI1IEMzOC44MTkzMzU5NCAyMS4wNjg3ODkwNiAzOC4wMTM2NzE4OCAyMC41NzUwNzgxMyAzNy4xODM1OTM3NSAyMC4wNjY0MDYyNSBDMTkuNzE1NjY3NDEgMTAuMzE0NzQ2NSAtMy45Mjc0MjU1OCA5LjkwNzI1NzU2IC0yMi44Nzg5MDYyNSAxNS4wMzUxNTYyNSBDLTM0LjUyNDQ0NzI4IDE4LjY4NTE3NDMxIC00Ni40MTAzNzI3MiAyNS4yNzM3NzcxNiAtNTUuMzc1IDMzLjU2MjUgQy01Ni41OTcwMzEyNSAzNC42NDkxNzk2OSAtNTYuNTk3MDMxMjUgMzQuNjQ5MTc5NjkgLTU3Ljg0Mzc1IDM1Ljc1NzgxMjUgQy02NC40NTQ2NTgzNSA0MS45NTA1NjA5OCAtNjguOTQxNjA1MyA0OC43MDg1MTE5OCAtNzMuMzc1IDU2LjU2MjUgQy03My45MzE4NzUgNTcuNDU3MTA5MzggLTc0LjQ4ODc1IDU4LjM1MTcxODc1IC03NS4wNjI1IDU5LjI3MzQzNzUgQy04MC44MTY4OTUwOSA2OC44NTQ1MDUzMyAtODIuOTM4NDc4ODggNzkuNTgyMzU4MzYgLTg0LjM3NSA5MC41NjI1IEMtODguMDA1IDkwLjU2MjUgLTkxLjYzNSA5MC41NjI1IC05NS4zNzUgOTAuNTYyNSBDLTk2LjczMjgwMTgxIDcxLjU1MzI3NDY5IC04OS41MTY3Mzc4NSA1Mi43NzgxNDY2MyAtNzcuMzc1IDM4LjI1IEMtNzUuNzEzNjM1NDggMzYuMzQ5NTE4NTUgLTc0LjA0NzQ1OTQ5IDM0LjQ1MzIyNTAxIC03Mi4zNzUgMzIuNTYyNSBDLTcxLjgwMTM2NzE5IDMxLjg0NDQ5MjE5IC03MS4yMjc3MzQzNyAzMS4xMjY0ODQzOCAtNzAuNjM2NzE4NzUgMzAuMzg2NzE4NzUgQy01OS45MDQ1OTI5MyAxNy4wOTgwNTY3NSAtNDQuMzYxODMzMzcgOC42NTk5OTY2NiAtMjguMzc1IDMuNTYyNSBDLTI3LjcwOTAzODA5IDMuMzAxMzg0MjggLTI3LjA0MzA3NjE3IDMuMDQwMjY4NTUgLTI2LjM1NjkzMzU5IDIuNzcxMjQwMjMgQy0xNy43OTcwNjk4MyAtMC4zMTI0MDg4MiAtOC45ODMxNTYyMyAtMC4wMzEzMTE5NCAwIDAgWiAiIGZpbGw9IiM2QTIyQzYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDk1LjM3NSwtMC41NjI1KSIvPgo8cGF0aCBkPSJNMCAwIEMzLjYzIDAgNy4yNiAwIDExIDAgQzExLjE5NTkzNzUgMS4wNDE1NjI1IDExLjM5MTg3NSAyLjA4MzEyNSAxMS41OTM3NSAzLjE1NjI1IEMxMy44MjAzMzQwMiAxNC4xMjE1NjM4NyAxNy41NDE2ODA4NyAyMy4yNjA4NjIwNCAyMyAzMyBDMjMuNDMzMTI1IDMzLjgwMDUwNzgxIDIzLjg2NjI1IDM0LjYwMTAxNTYzIDI0LjMxMjUgMzUuNDI1NzgxMjUgQzM1Ljg0MjE2NTYgNTUuNDAyNTI4MjQgNTYuNDM0MjkwMDMgNjcuMTMxNjc3NjkgNzcuNzkyOTY4NzUgNzMuODgyODEyNSBDMTAzLjg1Nzk5NTk5IDc5Ljc2NzEyNzA4IDEyNi45OTIxNDE5IDcxLjM2MzYxMzA3IDE0OC43NjU2MjUgNTcuNzM4MjgxMjUgQzE1MS4zMDg5NzM0NiA1NS43NTk2MjcyOSAxNTMuMDI4NjY2NTggNTMuNTM4NTk0NjcgMTU1IDUxIEMxNTYuMDk2MTM5OTMgNTAuMDQ5MDExMDIgMTU3LjIxOTk0NDU2IDQ5LjEyODQ5Mjg3IDE1OC4zNzUgNDguMjUgQzE2Mi41NjgzNTc2MiA0NC43MjQzNzQ0OCAxNjUuMTk1MjAwMTEgNDAuNjY3ODQyMTUgMTY4IDM2IEMxNjguNjYzODY3MTkgMzQuOTMyNjU2MjUgMTY5LjMyNzczNDM4IDMzLjg2NTMxMjUgMTcwLjAxMTcxODc1IDMyLjc2NTYyNSBDMTc2LjMwODQ0MDQyIDIyLjQxMjk5MjMxIDE3OS41ODczODIyMSAxMS44NjIwMzc0NyAxODIgMCBDMTg1LjMgMCAxODguNiAwIDE5MiAwIEMxOTMuMTg5ODgyNTkgMjIuMDQ1ODgwMTcgMTgzLjcwMzQxMDA5IDM5Ljk3MDY0NDI4IDE2OS41MjczNDM3NSA1Ni4yMDcwMzEyNSBDMTY1LjEwMTUzNjcxIDYxLjA3ODE3MjQxIDE2MC4zNTEzMjE5NSA2NS4xNTMyMjkwNiAxNTUgNjkgQzE1My43ODk1NzAzMSA2OS45MzAwNTg1OSAxNTMuNzg5NTcwMzEgNjkuOTMwMDU4NTkgMTUyLjU1NDY4NzUgNzAuODc4OTA2MjUgQzEzNi4wNjczODE3IDgzLjE1MTYxMTM3IDExNi45MTI3NTU2NyA4Ny45ODI1MTI3MiA5Ni42ODc1IDg3LjY4NzUgQzk1Ljg4MTgzNTk0IDg3LjY4MjM1MzgyIDk1LjA3NjE3MTg4IDg3LjY3NzIwNzY0IDk0LjI0NjA5Mzc1IDg3LjY3MTkwNTUyIEM4MS40MjgzMjgwNSA4Ny41NjEyOTI2MiA2OS43OTYzNjI5MiA4Ni4zODQ3NzcgNTggODEgQzU3LjM4MzgyODEzIDgwLjcyNzM2MzI4IDU2Ljc2NzY1NjI1IDgwLjQ1NDcyNjU2IDU2LjEzMjgxMjUgODAuMTczODI4MTIgQzQ3LjYzMzMwMzQgNzYuMzA0NTEwMTIgNDAuMjIyNTcyMiA3MC44NjE1MDk3NiAzMyA2NSBDMzIuMTM1MDM5MDYgNjQuMzAxMzI4MTIgMzEuMjcwMDc4MTMgNjMuNjAyNjU2MjUgMzAuMzc4OTA2MjUgNjIuODgyODEyNSBDMTQuNzQ0NDQ2NjIgNDkuNTY1NDcyNDcgMS41MTg3MDM4OSAyOC40MTU3ODYxOSAtMC4zMDA3ODEyNSA3LjU1MDc4MTI1IEMtMC4zMTA0NTY5NCA1LjAzMTg3NjYzIC0wLjE3NDUwNDk1IDIuNTEyODcxMjkgMCAwIFogIiBmaWxsPSIjNEIyMkM2IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLDEwNSkiLz4KPHBhdGggZD0iTTAgMCBDMC42Nzc0MDIzNCAwLjI5NDcxMTkxIDEuMzU0ODA0NjkgMC41ODk0MjM4MyAyLjA1MjczNDM4IDAuODkzMDY2NDEgQzEwLjk1MjAxNyA0LjgzNjIyNzgxIDE4LjgwOTA4NzQ5IDkuMzU0OTMyMzQgMjYgMTYgQzI2LjkyNTU0Njg4IDE2Ljg0NTYyNSAyNy44NTEwOTM3NSAxNy42OTEyNSAyOC44MDQ2ODc1IDE4LjU2MjUgQzM3Ljg1NDU2MTYgMjcuMTk1NDQyMjMgNDMuNDAwMTA5MDYgMzYuMTczMTIxMDQgNDguMzEyNSA0Ny41NjI1IEM0OC42NTA0NzYwNyA0OC4zNDE3MzgyOCA0OC45ODg0NTIxNSA0OS4xMjA5NzY1NiA0OS4zMzY2Njk5MiA0OS45MjM4MjgxMiBDNTIuMzkzMzIyODYgNTcuMzExMTkwOSA1NC41OTA2ODg1MyA2NC4wNDY1NTczNiA1MyA3MiBDNDkuMDQgNzIgNDUuMDggNzIgNDEgNzIgQzQwLjg0MTQ0NTMxIDcxLjEyODU5Mzc1IDQwLjY4Mjg5MDYyIDcwLjI1NzE4NzUgNDAuNTE5NTMxMjUgNjkuMzU5Mzc1IEMzOC4wMDc4NjkyNCA1Ni41Mzc0MDk4IDMzLjk0OTUyMzcxIDQ2LjM3MjU1MTgyIDI2IDM2IEMyNS4zOTI4NTE1NiAzNS4xNDI3NzM0NCAyNC43ODU3MDMxMiAzNC4yODU1NDY4OCAyNC4xNjAxNTYyNSAzMy40MDIzNDM3NSBDMTkuMzA0OTM1NjcgMjYuODE5NDk4NjcgMTQuMDQyMTQxMjcgMjMuMDM2ODMzMDkgNyAxOSBDNi4yMDg1MTU2MyAxOC40NjUwMzkwNiA1LjQxNzAzMTI1IDE3LjkzMDA3ODEzIDQuNjAxNTYyNSAxNy4zNzg5MDYyNSBDLTkuNTA2MzQ3MjkgNy45ODE0NDQ3NCAtMjcuNTMwMzM3MTggNi40MjE1OTAyNSAtNDMuODYzNTI1MzkgOS41NDA1MjczNCBDLTU1LjMzNjg0NTAxIDExLjk5NTk5NDA3IC02NC41NjE2MTgyMSAxNy4xMjA3MTI5OCAtNzQgMjQgQy03NC42NTc0MjE4NyAyNC40NTg5MDYyNSAtNzUuMzE0ODQzNzUgMjQuOTE3ODEyNSAtNzUuOTkyMTg3NSAyNS4zOTA2MjUgQy04Mi4wMzEzNzQyNiAzMC4wMTA0NjM3MiAtODUuOTQzMjA4OTcgMzYuNjgxNzk2MjYgLTkwIDQzIEMtOTAuNTA5MTc5NjkgNDMuNzg3NjE3MTkgLTkxLjAxODM1OTM4IDQ0LjU3NTIzNDM4IC05MS41NDI5Njg3NSA0NS4zODY3MTg3NSBDLTk1LjIyOTgwMzg5IDUxLjUyMzg4MTI1IC05Ny4wODg2NDU1NiA1OC4xMzg1MDE4IC05OSA2NSBDLTk5LjQxNjQ0NjQ3IDY2LjQzNzU2MzgxIC05OS44MzMwNjA0NyA2Ny44NzUwNzkxMiAtMTAwLjI1IDY5LjMxMjUgQy0xMDAuNjIxMjUgNzAuNjQyODEyNSAtMTAwLjYyMTI1IDcwLjY0MjgxMjUgLTEwMSA3MiBDLTEwNC45NiA3MiAtMTA4LjkyIDcyIC0xMTMgNzIgQy0xMTMuNDM3NDM0MzMgNjEuNzIwMjkzMzMgLTExMC4xODc5MDgwOCA1My4yODg4Nzc1MiAtMTA2IDQ0IEMtMTA1LjYxODQzNzUgNDMuMTI5ODgyODEgLTEwNS4yMzY4NzUgNDIuMjU5NzY1NjIgLTEwNC44NDM3NSA0MS4zNjMyODEyNSBDLTEwMC44MTgyMDU1NSAzMi43MDAyMDA3OSAtOTQuOTA3Njc5MDEgMjUuNTUzNDM5MDYgLTg4IDE5IEMtODcuNTQ4ODI4MTIgMTguNDkzMzk4NDQgLTg3LjA5NzY1NjI1IDE3Ljk4Njc5Njg3IC04Ni42MzI4MTI1IDE3LjQ2NDg0Mzc1IEMtNjYuMDg3Njc4MzEgLTQuOTcxMjYwNSAtMjcuNDg2NTE4MjUgLTEyLjI5Njk3ODk4IDAgMCBaICIgZmlsbD0iIzY4MjNDNiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTI2LDE4KSIvPgo8cGF0aCBkPSJNMCAwIEMzLjYzIDAgNy4yNiAwIDExIDAgQzExLjM5MTg3NSAxLjIzNzUgMTEuNzgzNzUgMi40NzUgMTIuMTg3NSAzLjc1IEMxNS42MzY1MTMyOSAxMy45ODQ3NDY0MSAxOS43OTUyODY3IDIzLjEzMDUyNTYyIDI2IDMyIEMyNi41NjA3NDIxOSAzMi44NDQzMzU5NCAyNy4xMjE0ODQzOCAzMy42ODg2NzE4OCAyNy42OTkyMTg3NSAzNC41NTg1OTM3NSBDMzcuMDkwOTg4MTEgNDcuNjE3NDMxNDEgNTQuMDk0ODA4MTggNTYuNTk4MjQ2NyA2OS42ODA2NjQwNiA1OS42NTQyOTY4OCBDODguMTg2Njg4NTcgNjIuNDEyNjY4NTMgMTA1LjQxNTk5NDMyIDU5LjUyOTE2NjY5IDEyMSA0OSBDMTIyLjAwOTMzNTk0IDQ4LjM1Mjg5MDYyIDEyMy4wMTg2NzE4NyA0Ny43MDU3ODEyNSAxMjQuMDU4NTkzNzUgNDcuMDM5MDYyNSBDMTMyLjM4NzU1ODg3IDQxLjMzMDgwMzYgMTM3Ljc0NzEyMjQyIDM0LjQ2OTQ2NjM4IDE0MyAyNiBDMTQzLjUzMTM3NTczIDI1LjE1MDA2NDcgMTQzLjUzMTM3NTczIDI1LjE1MDA2NDcgMTQ0LjA3MzQ4NjMzIDI0LjI4Mjk1ODk4IEMxNDYuNTczMjczNjUgMjAuMTE4NjAzMjYgMTQ4LjIzNjEwOTA3IDE1LjkzNzM1MDIgMTQ5LjY4NzUgMTEuMzEyNSBDMTQ5Ljg5OTU1MDc4IDEwLjY2MjE2Nzk3IDE1MC4xMTE2MDE1NiAxMC4wMTE4MzU5NCAxNTAuMzMwMDc4MTIgOS4zNDE3OTY4OCBDMTUxLjMzMTE5NjgxIDYuMjQzNjk3NzMgMTUyLjIwOTg2MDkyIDMuMTYwNTU2MzQgMTUzIDAgQzE1Ni45NiAwIDE2MC45MiAwIDE2NSAwIEMxNjYuNTQ2OTc2NjQgNi4xODc5MDY1NCAxNjQuMDI2ODc5ODUgMTEuMDg3NzI3NDcgMTYyIDE3IEMxNjEuNjQ4MDg1OTQgMTguMDg0MTAxNTYgMTYxLjI5NjE3MTg3IDE5LjE2ODIwMzEzIDE2MC45MzM1OTM3NSAyMC4yODUxNTYyNSBDMTU0LjEzMzA0NTc2IDM5Ljc4NjM3OTIzIDEzOS4wMzQwNjcwOCA1NS4zNDY4MjYzNSAxMjEgNjUgQzExNi43MzY1MTA3MSA2Ni45MTczNjU4IDExMi40MzM1MDc4MSA2OC41MjQxMDA5NCAxMDggNzAgQzEwNy4xMjk4ODI4MSA3MC4zMDY3OTY4OCAxMDYuMjU5NzY1NjIgNzAuNjEzNTkzNzUgMTA1LjM2MzI4MTI1IDcwLjkyOTY4NzUgQzk3Ljc1MzA1NDg3IDczLjU3MTI1MzY4IDkwLjkxMDI1MzcyIDc0LjIwODc5MzU3IDgyLjg3NSA3NC4yNSBDODEuODkyNzM0MzggNzQuMjcwNjI1IDgwLjkxMDQ2ODc1IDc0LjI5MTI1IDc5Ljg5ODQzNzUgNzQuMzEyNSBDNzIuODA2OTQyOTkgNzQuMzQ5ODIzNjYgNjYuNzI2MDU3NDEgNzMuMjAyNjcwMjkgNjAgNzEgQzU5LjI3OTI1MjkzIDcwLjc3MDIyNDYxIDU4LjU1ODUwNTg2IDcwLjU0MDQ0OTIyIDU3LjgxNTkxNzk3IDcwLjMwMzcxMDk0IEM0NC4wNTAwOTU2NiA2NS43NDc1MzU3NyAzMy41MTY4NTc4OSA1OS4wNDYyMjM5OCAyMyA0OSBDMjIuMDc3Njc1NzggNDguMTg5ODI0MjIgMjIuMDc3Njc1NzggNDguMTg5ODI0MjIgMjEuMTM2NzE4NzUgNDcuMzYzMjgxMjUgQzkuNzQwNzQ2MjQgMzYuOTYyODE4OTggMS41MjI5NTQ3MyAyMC4xMzc3MjgzNiAtMSA1IEMtMC42NyAzLjM1IC0wLjM0IDEuNyAwIDAgWiAiIGZpbGw9IiM0RDIyQzYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE0LDEwNSkiLz4KPHBhdGggZD0iTTAgMCBDMC45OSAwIDEuOTggMCAzIDAgQzMuMzQwMzEyNSAwLjkyODEyNSAzLjM0MDMxMjUgMC45MjgxMjUgMy42ODc1IDEuODc1IEM1LjM3OTI5ODM1IDQuNjE0MTAyMDkgNi45OTI0NDE2MSA1LjA1MDI0NDcyIDEwIDYgQzkuMTI1IDEwLjc1IDkuMTI1IDEwLjc1IDggMTMgQzcuOTYwMzI4NyAxNC42NjYxOTQ0NiA3Ljk1NjE1NTUzIDE2LjMzMzkxMDEzIDggMTggQzYuNzgzMTI1IDE3LjgxNDM3NSA1LjU2NjI1IDE3LjYyODc1IDQuMzEyNSAxNy40Mzc1IEMwLjk3MDIyMDYxIDE3LjAxMDA2ODE4IC0xLjcxOTY4NDE3IDE3LjA3NzQxMTE3IC01IDE4IEMtNC45MDcxODc1IDE2LjYzODc1IC00LjkwNzE4NzUgMTYuNjM4NzUgLTQuODEyNSAxNS4yNSBDLTUuMDE5ODM0MTcgMTEuNjU2MjA3NjUgLTUuNzI0NjAyMzcgMTAuNjU0NjMwNTcgLTggOCBDLTggNy4zNCAtOCA2LjY4IC04IDYgQy03LjA1MTI1IDUuNzUyNSAtNi4xMDI1IDUuNTA1IC01LjEyNSA1LjI1IEMtMS45MTMwNjgwOSA0LjMxNDI5MjMgLTEuOTEzMDY4MDkgNC4zMTQyOTIzIC0wLjYyNSAxLjg3NSBDLTAuNDE4NzUgMS4yNTYyNSAtMC4yMTI1IDAuNjM3NSAwIDAgWiAiIGZpbGw9IiM0RDIyQzUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDk1LDEzOSkiLz4KPHBhdGggZD0iTTAgMCBDMS4zNzU2Mjg1NCAxLjI4OTY1MTc2IDIuNzA3NjYzOTMgMi42MjY4OTI5MyA0IDQgQzQgNC42NiA0IDUuMzIgNCA2IEM1LjY1IDYgNy4zIDYgOSA2IEM5LjMzIDcuMzIgOS42NiA4LjY0IDEwIDEwIEM5LjAxIDEwLjY2IDguMDIgMTEuMzIgNyAxMiBDNi43NDk3ODQzIDE1LjA4MzY1ODcxIDYuNzQ5Nzg0MyAxNS4wODM2NTg3MSA3IDE4IEM2LjM0IDE4LjMzIDUuNjggMTguNjYgNSAxOSBDMy44NTUzMTI1IDE4LjQ3NDA2MjUgMy44NTUzMTI1IDE4LjQ3NDA2MjUgMi42ODc1IDE3LjkzNzUgQy0wLjAxMDU0NjU0IDE2LjY5NzM4Mjg1IC0wLjAxMDU0NjU0IDE2LjY5NzM4Mjg1IC0yLjgxMjUgMTcuODc1IEMtMy41MzQzNzUgMTguMjQ2MjUgLTQuMjU2MjUgMTguNjE3NSAtNSAxOSBDLTUuNjg3MDc1NTUgMTYuNTA5MzUxMTIgLTYgMTQuNjIxMTM3MDggLTYgMTIgQy02Ljk5IDExLjM0IC03Ljk4IDEwLjY4IC05IDEwIEMtOC42NyA4LjY4IC04LjM0IDcuMzYgLTggNiBDLTYuODU1MzEyNSA1LjkwNzE4NzUgLTYuODU1MzEyNSA1LjkwNzE4NzUgLTUuNjg3NSA1LjgxMjUgQy0yLjc2OTQ4MTkxIDUuMjMwNjQ3MzggLTIuNzY5NDgxOTEgNS4yMzA2NDczOCAtMS4xODc1IDIuNDM3NSBDLTAuNzk1NjI1IDEuNjMzMTI1IC0wLjQwMzc1IDAuODI4NzUgMCAwIFogIiBmaWxsPSIjNTUyMkM2IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg0OCwxMDgpIi8+CjxwYXRoIGQ9Ik0wIDAgQzAuOTkgMCAxLjk4IDAgMyAwIEMzLjMzIDEuNjUgMy42NiAzLjMgNCA1IEM1Ljk4IDUgNy45NiA1IDEwIDUgQzkuMTI1IDguODc1IDkuMTI1IDguODc1IDggMTAgQzcuNzY5MjQ5MTggMTEuMzQ3NDcwODQgNy41ODg0NjkzNyAxMi43MDM3NzU2NSA3LjQzNzUgMTQuMDYyNSBDNy4yOTMxMjUgMTUuMzYxODc1IDcuMTQ4NzUgMTYuNjYxMjUgNyAxOCBDNS43NjI1IDE3LjgxNDM3NSA0LjUyNSAxNy42Mjg3NSAzLjI1IDE3LjQzNzUgQzAuMjM3MjA0MjMgMTcuMDUyODg3NzcgLTIuMTAwMTA4MjcgMTYuOTEyNTQwNiAtNSAxOCBDLTYuMDQ0NDk5MTEgMTQuODY2NTAyNjggLTUuOTM0MjM2NDUgMTQuMDEwMzE3NDQgLTUgMTEgQy02LjMyIDEwLjAxIC03LjY0IDkuMDIgLTkgOCBDLTguNjcgNy4wMSAtOC4zNCA2LjAyIC04IDUgQy02LjU3Njg3NSA0Ljg3NjI1IC02LjU3Njg3NSA0Ljg3NjI1IC01LjEyNSA0Ljc1IEMtMS44OTUzODIwOSA0LjM0OTI1MDc3IC0xLjg5NTM4MjA5IDQuMzQ5MjUwNzcgLTAuNjI1IDEuOTM3NSBDLTAuNDE4NzUgMS4yOTgxMjUgLTAuMjEyNSAwLjY1ODc1IDAgMCBaICIgZmlsbD0iIzY1MjNDNSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjcsNTEpIi8+CjxwYXRoIGQ9Ik0wIDAgQzMgMiAzIDIgNCA1IEM1LjY1IDUuMzMgNy4zIDUuNjYgOSA2IEM4LjUzODA0Njk1IDguMzc1NzU4NTYgOC4wNzQ1MDU3NyAxMC43MjY4MTIxNyA3LjQzNzUgMTMuMDYyNSBDNi44NTMxNTk0MiAxNS4zMTkyNDcxNiA2Ljg1MzE1OTQyIDE1LjMxOTI0NzE2IDcgMTkgQzIuMjUgMTguMTI1IDIuMjUgMTguMTI1IDAgMTcgQy0yLjYwOTMxMjY2IDE3Ljg5MzYzNjA1IC0yLjYwOTMxMjY2IDE3Ljg5MzYzNjA1IC01IDE5IEMtNS4zMyAxOC42NyAtNS42NiAxOC4zNCAtNiAxOCBDLTUuOTU4NzUgMTcuMDUxMjUgLTUuOTE3NSAxNi4xMDI1IC01Ljg3NSAxNS4xMjUgQy01LjY3NjEyODczIDEyLjAxMTkyMTY0IC01LjY3NjEyODczIDEyLjAxMTkyMTY0IC03LjUgMTAuMjUgQy03Ljk5NSA5LjgzNzUgLTguNDkgOS40MjUgLTkgOSBDLTkgOC4zNCAtOSA3LjY4IC05IDcgQy03LjU3Njg3NSA2LjkwNzE4NzUgLTcuNTc2ODc1IDYuOTA3MTg3NSAtNi4xMjUgNi44MTI1IEMtNS4wOTM3NSA2LjU0NDM3NSAtNC4wNjI1IDYuMjc2MjUgLTMgNiBDLTEuNjExNDExMjggMy41NzExNDIxMiAtMS42MTE0MTEyOCAzLjU3MTE0MjEyIC0xIDEgQy0wLjY3IDAuNjcgLTAuMzQgMC4zNCAwIDAgWiAiIGZpbGw9IiM1NTIyQzYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE0NCwxMDgpIi8+CjxwYXRoIGQ9Ik0wIDAgQzAuOTkgMCAxLjk4IDAgMyAwIEMzLjMzIDEuNjUgMy42NiAzLjMgNCA1IEM2LjMxIDUgOC42MiA1IDExIDUgQzEwLjEyNSA4Ljg3NSAxMC4xMjUgOC44NzUgOSAxMCBDOC42MzIzOTI2OSAxMi4zMjgxNzk2NCA4LjI5NzU4NDE5IDE0LjY2MTgzODUgOCAxNyBDNi42OCAxNyA1LjM2IDE3IDQgMTcgQzIuNTgwOTUzMjQgMTcuMTQ1MDEyMDggMS4xNjM5MjQwNSAxNy4zMTE0NzY3OSAtMC4yNSAxNy41IEMtMi4xMDYyNSAxNy43NDc1IC0yLjEwNjI1IDE3Ljc0NzUgLTQgMTggQy01IDE1IC01IDE1IC00LjkzNzUgMTIuNDM3NSBDLTQuNzI0NzI2NzggOS44MTYxMDY5MSAtNC43MjQ3MjY3OCA5LjgxNjEwNjkxIC03IDggQy03IDcuMDEgLTcgNi4wMiAtNyA1IEMtNS44MjQzNzUgNC44NzYyNSAtNS44MjQzNzUgNC44NzYyNSAtNC42MjUgNC43NSBDLTEuODUyNTA4OTYgNC4yNzE5MzY2MSAtMS44NTI1MDg5NiA0LjI3MTkzNjYxIC0wLjY4NzUgMS45Mzc1IEMtMC40NjA2MjUgMS4yOTgxMjUgLTAuMjMzNzUgMC42NTg3NSAwIDAgWiAiIGZpbGw9IiM2NTIzQzYiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEyMyw1MSkiLz4KPHBhdGggZD0iTTAgMCBDMi41IDAuMTg3NSAyLjUgMC4xODc1IDUgMSBDNyA0IDcgNCA2LjYyNSA3LjE4NzUgQzYuNDE4NzUgOC4xMTU2MjUgNi4yMTI1IDkuMDQzNzUgNiAxMCBDMy43NSAxMC43NSAzLjc1IDEwLjc1IDEgMTEgQy0xLjM3NSA5LjM3NSAtMS4zNzUgOS4zNzUgLTMgNyBDLTIuODM4NDk3OTUgMy42MDg0NTcwNSAtMi40MTcwMzI0MyAyLjQxNzAzMjQzIDAgMCBaICIgZmlsbD0iIzVCMjJDNyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTQ5LDkzKSIvPgo8cGF0aCBkPSJNMCAwIEMyLjM3NSAwLjgxMjUgMi4zNzUgMC44MTI1IDMuMzc1IDIuODEyNSBDMy42MjUgNS44MTI1IDMuNjI1IDUuODEyNSAzLjM3NSA4LjgxMjUgQzAuMzc1IDEwLjgxMjUgMC4zNzUgMTAuODEyNSAtMi4yNSAxMC41IEMtNC42MjUgOS44MTI1IC00LjYyNSA5LjgxMjUgLTUuNjI1IDguODEyNSBDLTYuMDgxOTEzODMgMy41NTc5OTA5OCAtNi4wODE5MTM4MyAzLjU1Nzk5MDk4IC00LjQzNzUgMC44NzUgQy0yLjYyNSAtMC4xODc1IC0yLjYyNSAtMC4xODc1IDAgMCBaICIgZmlsbD0iIzVBMjJDNSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNDIuNjI1LDkzLjE4NzUpIi8+Cjwvc3ZnPgo=', 2);
        }

        /** Welcome Page */
        public function welcome_screen()
        {
            $tabs = $this->tab_sections;
            ?>
            <div class="welcome-wrap">
                <div class="welcome-main-content">
                    <?php require_once get_template_directory() . '/welcome/sections/header.php'; ?>

                    <div class="welcome-section-wrapper">
                        <?php $section = isset($_GET['section']) && array_key_exists($_GET['section'], $tabs) ? $_GET['section'] : 'getting_started'; ?>

                        <div class="welcome-section <?php echo esc_attr($section); ?> clearfix">
                            <?php require_once get_template_directory() . '/welcome/sections/' . $section . '.php'; ?>
                        </div>
                    </div>
                </div>

                <div class="welcome-footer-content">
                    <?php require_once get_template_directory() . '/welcome/sections/footer.php'; ?>
                </div>
            </div>
            <?php
        }

        /** Enqueue Necessary Styles and Scripts for the Welcome Page */
        public function welcome_styles_and_scripts($hook)
        {
            if ('theme-install.php' !== $hook) {
                $importer_params = array(
                    'installing_text' => esc_html__('Installing Demo Importer Plugin', 'educenter'),
                    'activating_text' => esc_html__('Activating Demo Importer Plugin', 'educenter'),
                    'importer_page' => esc_html__('Go to Demo Importer Page', 'educenter'),
                    'importer_url' => admin_url('themes.php?page=sparkle-theme-demo-importer'),
                    'error' => esc_html__('Error! Reload the page and try again.', 'educenter'),
                );
                wp_enqueue_style('educenter-welcome', get_template_directory_uri() . '/welcome/css/welcome.css', array());
                wp_enqueue_script('educenter-welcome', get_template_directory_uri() . '/welcome/js/welcome.js', array('plugin-install', 'updates'), '', true);
                wp_localize_script('educenter-welcome', 'importer_params', $importer_params);
            }
        }

        /* Check if plugin is installed */

        public function check_plugin_installed_state($slug, $filename)
        {
            return file_exists(ABSPATH . 'wp-content/plugins/' . $slug . '/' . $filename . '.php') ? true : false;
        }

        /* Check if plugin is activated */

        public function check_plugin_active_state($slug, $filename)
        {
            return is_plugin_active($slug . '/' . $filename . '.php') ? true : false;
        }

        /** Generate Url for the Plugin Button */
        public function plugin_generate_url($status, $slug, $file_name)
        {
            switch ($status) {
                case 'install':
                    return wp_nonce_url(add_query_arg(array(
                        'action' => 'install-plugin',
                        'plugin' => esc_attr($slug)
                    ), network_admin_url('update.php')), 'install-plugin_' . esc_attr($slug));
                    break;

                case 'inactive':
                    return add_query_arg(array(
                        'action' => 'deactivate',
                        'plugin' => rawurlencode(esc_attr($slug) . '/' . esc_attr($file_name) . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('deactivate-plugin_' . esc_attr($slug) . '/' . esc_attr($file_name) . '.php'),
                    ), network_admin_url('plugins.php'));
                    break;

                case 'active':
                    return add_query_arg(array(
                        'action' => 'activate',
                        'plugin' => rawurlencode(esc_attr($slug) . '/' . esc_attr($file_name) . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('activate-plugin_' . esc_attr($slug) . '/' . esc_attr($file_name) . '.php'),
                    ), network_admin_url('plugins.php'));
                    break;
            }
        }

        /** Ajax Plugin Activation */
        public function activate_plugin()
        {
            if (current_user_can('activate_plugins') == false) {
                $data = ['message' => 'You cannot activate plugins!'];
                wp_send_json_error($data);
            }

            $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
            $file = isset($_POST['file']) ? $_POST['file'] : '';
            $success = false;

            if (!empty($slug) && !empty($file)) {
                $result = activate_plugin($slug . '/' . $file . '.php');
                update_option('educenter_hide_notice', true);
                if (!is_wp_error($result)) {
                    $success = true;
                }
            }
            echo wp_json_encode(array('success' => $success));
            die();
        }

        /** Adds Footer Notes */
        public function admin_footer_text($text)
        {
            $screen = get_current_screen();

            if ('appearance_page_educenter-welcome' == $screen->id) {
                $text = sprintf(esc_html__('Please leave us a %s rating if you like our theme . A huge thank you from SparkleThemes in advance!', 'educenter'), '<a href="https://wordpress.org/support/theme/educenter/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>');
            }

            return $text;
        }

        /** Generate One Click Demo Importer Plugin Install Button Link */
        public function generate_demo_installer_button()
        {
            $slug = $filename = 'sparkle-demo-importer';
            $import_url = '#';

            if ($this->check_plugin_installed_state($slug, $filename) && !$this->check_plugin_active_state($slug, $filename)) {
                $import_class = 'button button-primary educenter-activate-plugin';
                $import_button_text = esc_html__('Activate Demo Importer Plugin', 'educenter');
            } elseif ($this->check_plugin_installed_state($slug, $filename)) {
                $import_class = 'button button-primary';
                $import_button_text = esc_html__('Go to Demo Importer Page', 'educenter');
                $import_url = admin_url('/themes.php?page=sparkle-theme-demo-importer');

            } else {
                $import_class = 'button button-primary educenter-install-plugin';
                $import_button_text = esc_html__('Install Demo Importer Plugin', 'educenter');
            }
            return '<a data-slug="' . esc_attr($slug) . '" data-filename="' . esc_attr($filename) . '" class="' . esc_attr($import_class) . '" href="' . $import_url . '">' . esc_html($import_button_text) . '</a>';
        }

        public function erase_hide_notice()
        {
            delete_option('educenter_hide_notice');
        }

    }

    new EduCenter_Welcome();

endif;
