<?php



/**
 * Description of Option
 *
 * @author nicearma
 */
class OptionsRestCUF
{


 	function __construct()
    {
        set_error_handler(array('ErrorHandlerCUF', 'errorHandler'));
    }
    
    public function read()
    {
        $optionsCUF = OptionsRestCUF::readOptions();
        echo json_encode($optionsCUF);
        wp_die();
    }

    public function update()
    {
        $optionsJson = json_decode(file_get_contents('php://input'));
        $optionsCUF = ConvertOptionsCUF::convertOptionJsonToOptionCUF($optionsJson);
        update_option('CUF_options', serialize($optionsCUF));
        wp_die();
    }


    public static function readOptions()
    {
        $optionsCUF = get_option("CUF_options");
        if (empty($optionsCUF)) {
            $optionsCUF = new OptionsCUF();
        } else {
            $optionsCUF = unserialize($optionsCUF);
            $optionsCUF = ConvertOptionsCUF::convertOldTONew($optionsCUF);
        }
        return $optionsCUF;
    }

    public function restore()
    {

        $optionsCUF = new OptionsCUF();
        update_option('CUF_options', serialize($optionsCUF));
        echo json_encode($optionsCUF);
        wp_die();
    }

	public function haveWooCommerce(){
        $haveWC=array("active"=>in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
        echo json_encode($haveWC);
        wp_die();
    }

}
