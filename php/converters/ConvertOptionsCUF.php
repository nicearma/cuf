<?php
/**
 *
 * @author nicearma
 */
class ConvertOptionsCUF
{

    //TODO: end the logic

    public static function convertOldTONew($optionsOld)
    {

        if (is_array($optionsOld) && array_key_exists('version', $optionsOld)) {
            if ($optionsOld['version'] == '0.1') {
                $optionsCUF = ConvertOptionsCUF::convert0_1to1_0($optionsOld);
            } else {
                $optionsCUF = new OptionsDCUF();
            }
        } else if (empty($optionsOld)) {
            $optionsCUF = new OptionsDNUI();
        } else {
            $optionsCUF = $optionsOld;
        }

        if ($optionsCUF->getVersion() != '1.0') {
            //TODO: nothing for the moment
        }

        return $optionsCUF;
    }

    public static function convert0_1to1_0($option0_1)
    {
        $optionCUF = new OptionsCUF();
       
        return $optionCUF;

    }

    public static function convertOptionJsonToOptionDNUI($optionJson)
    {
        $optionsCUF = new OptionsUCF();
        $optionsCUF->setUpdateInServer($optionJson->updateInServer);
        $optionsCUF->setBackup($optionJson->backup);
        $optionsCUF->setAdmin($optionJson->admin);

      
        $optionsCUF->setGalleryCheck($optionJson->galleryCheck);
        $optionsCUF->setShortCodeCheck($optionJson->galleryCheck);
        $optionsCUF->setExcerptCheck($optionJson->excerptCheck);
        $optionsCUF->setPostMetaCheck($optionJson->postMetaCheck);
        $optionsCUF->setDraftCheck($optionJson->draftCheck);
      
        $optionsCUF->setOrder($optionJson->order);
 	$optionsCUF->setDebug($optionJson->debug);

        return $optionsCUF;

    }

}
