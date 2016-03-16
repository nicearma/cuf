<?php

/**
 * All about database and SQL to search image
 *
 * @author nicearma
 */
class DatabaseCUF
{

    private $db;
    private $prefix;

    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->prefix = $wpdb->prefix;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get all image from the database with options
     */
    public function countAttachment()
    {

        $sql = 'SELECT count(*) FROM ' . $this->prefix . 'posts, ' . $this->prefix . "postmeta where " . $this->prefix . "posts.post_type='attachment' and " . $this->prefix . "posts.id=" . $this->prefix . "postmeta.post_id and " . $this->prefix . "postmeta.meta_key='_wp_attachment_metadata' ";

        return $this->db->get_results($sql, "ARRAY_A");

    }


    public function getGalleries($optionsCUF)
    {

        if ($optionsCUF->isDraftCheck()) {
            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item') and post_content LIKE '%[gallery%'";
        } else {
            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item','revision') and post_status !='draft' AND post_content LIKE '%[gallery%'; ";
        }

        return $this->db->get_results($sql, "ARRAY_A");

    }


        public function getShortCodeContent($optionsCUF)
    {

        if ($optionsCUF->isDraftCheck()) {

            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item')  AND post_content REGEXP  '\\\[(\\\[?)(.*)';";

        } else {

            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item','revision') and post_status !='draft'  AND post_content REGEXP  '\\\[(\\\[?)(.*)'; ";

        }

        return $this->db->get_results($sql, "ARRAY_A");

    }

    public function getShortCodeExcerpt($optionsCUF)
    {

        if ($optionsCUF->isDraftCheck()) {

            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_excerpt is not null and post_excerpt!=''  and post_type not in ('attachment','nav_menu_item')  AND post_excerpt REGEXP  '\\\[(\\\[?)(.*)';";

        } else {

            $sql = "SELECT id FROM " . $this->prefix . "posts  WHERE  post_excerpt is not null and post_excerpt!=''  and post_type not in ('attachment','nav_menu_item','revision') and post_status !='draft'  AND post_excerpt REGEXP  '\\\[(\\\[?)(.*)'; ";

        }

        return $this->db->get_results($sql, "ARRAY_A");

    }


    /**
     * Get the post information (this is use for the backup)
     *
     * @param type $id Id of the post
     * @return type
     */
    public function getRowPost($id)
    {

        $sql = 'SELECT * FROM ' . $this->prefix . 'posts where id=' . $id . ';';
        return $this->db->get_results($sql, "ARRAY_A");
    }

    /**
     * Get the postmeta information (This is use for the backup file)
     *
     * @param type $id Id of the post
     * @return type
     */
    public function getRowPostMeta($id)
    {
        $sql = 'SELECT * FROM ' . $this->prefix . 'postmeta where post_id=' . $id . ';';
        return $this->db->get_results($sql, "ARRAY_A");
    }


    //TODO: change this
    public function delete($imageCUF, $sizeNames, $optionsCUF)
    {
        $statusBySizes = array();

        $uploadDir = wp_upload_dir();
        $attachment = wp_get_attachment_metadata($imageCUF->getId());
        $basedir = $uploadDir['basedir'];

        foreach ($sizeNames as $sizeName) {

            $statusBySizes[$sizeName] = new StatusCUF();

            if ($sizeName == "original") {
                wp_delete_attachment($imageCUF->getId());
                $statusBySizes['original'] = new StatusCUF();

                $statusBySizes['original']->setUsed(2); //2 -> deleted
                $statusBySizes['original']->setInServer(0);
            } else {

                clearstatcache();
                $imageSizes = $imageCUF->getImageSizes();
                $srcInServer = $basedir . '/' . $imageSizes[$sizeName]->getSrcSizeImage();

                if (!file_exists($srcInServer)) {

                    unset($attachment["sizes"][$sizeName]);
                    wp_update_attachment_metadata($imageCUF->getId(), $attachment);

                    $statusBySizes[$sizeName]->setUsed(2);
                    $statusBySizes[$sizeName]->setInServer(0);
                } else {

                    if (@unlink($srcInServer)) {
                        clearstatcache();
                        if (!file_exists($srcInServer)) {
                            unset($attachment["sizes"][$sizeName]);
                            wp_update_attachment_metadata($imageCUF->getId(), $attachment);
                            $statusBySizes[$sizeName]->setUsed(2);
                            $statusBySizes[$sizeName]->setInServer(0);
                        } else {
                            $statusBySizes[$sizeName]->setUsed(-3); //-3 -> error
                            $statusBySizes[$sizeName]->setInServer(1);
                        }

                    }
                }


            }
        }
        return $statusBySizes;


    }





}
