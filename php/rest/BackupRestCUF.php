<?php


/**
 * Description of Backup
 *
 * @author nicearma
 */
class BackupRestCUF  extends BasicRestCUF
{



    function __construct()
    {

        parent::__construct();

    }

    public function readAll()
    {
        echo json_encode($this->helpCUF->getFilesFromFolder($this->helpCUF->backupDir()), JSON_FORCE_OBJECT);
        wp_die();
    }


    public function deleteFileByDirAndName()
    {
        $json = json_decode(file_get_contents('php://input'), true);

        $backupId = $json['id'];
        if (!is_numeric($backupId)) {
            //nothing to do, this case is not possible but for security reason
            return;
        }

        $statusBackup = new StatusBackupCUF();
        $backupDir = $this->helpCUF->backupDir();
        $backupIdPath = $backupDir . '/' . $backupId . '/';
        $backFiles =$this->helpCUF->getFilesFromFolder($backupIdPath);
        foreach ($backFiles as $file) {
            @unlink($backupIdPath . $file);
        }

        @rmdir($backupIdPath);
        clearstatcache();
        if (file_exists($backupIdPath)) {
            $statusBackup->setInServer(-4); //can not be deteleted
        } else {
            $statusBackup->setInServer(3);
        }
        echo json_encode($statusBackup);
        wp_die();
    }

    public function makeByDirAndFile()
    {

        $json = json_decode(file_get_contents('php://input'), true);

        $imageId = $json['id'];

        if (!is_numeric($imageId)) {
            //nothing to do, this case is not possible but for security reason
            return;
        }

        $sizeNames = $json['sizeNames'];

        if (!is_array($sizeNames)) {
            //nothing to do, this case is not possible but for security reason
            return;
        }

        $statusBySizes = array();

        $imageCUF = ConvertWordpressToCUF::convertIdToImageCUF($imageId);

        $backupDir = $this->helpCUF->backupDir();
        $uploadDir = wp_upload_dir();
        $basedir = $uploadDir['basedir'];

        if (is_writable($backupDir)) {
            $tmpBackupDirImage = $backupDir . '/' . $imageId . '/';
            if (!file_exists($tmpBackupDirImage)) {
                mkdir($tmpBackupDirImage, 0755, true);
            }

            $backupInfo = array();
            $uploadDirs = explode("/", $imageCUF->getSrcOriginalImage());
            array_pop($uploadDirs);
            $uploadDir = implode("/", $uploadDirs);
            $backupInfo["uploadDir"] = $uploadDir;
            $backupInfo["posts"] = $this->databaseCUF->getRowPost($imageId);
            $backupInfo["postMeta"] = $this->databaseCUF->getRowPostMeta($imageId);

            $tmpBackupFileImage = $tmpBackupDirImage . $imageId . '.backup';
            if (!file_exists($tmpBackupFileImage)) {
                file_put_contents($tmpBackupFileImage, serialize($backupInfo));
            }

            foreach ($sizeNames as $sizeName) {

                if ($sizeName == 'original') {
                    $originalPath = $basedir . '/' . $imageCUF->getSrcOriginalImage();
                    $imageTempBackupPath = $tmpBackupDirImage . $imageCUF->getName();
                    if (file_exists($originalPath)) {
                        copy($originalPath, $imageTempBackupPath);
                    }

                    foreach ($imageCUF->getImageSizes() as $imageSize) {
                        $originalPath = $basedir . '/' . $imageSize->getSrcSizeImage();
                        $imageTempBackupPath = $tmpBackupDirImage . $imageSize->getName();
                        if (file_exists($originalPath)) {
                            copy($originalPath, $imageTempBackupPath);
                        }

                    }
                } else {
                    $imageSizes = $imageCUF->getImageSizes();
                    $originalPath = $basedir . '/' . $imageSizes[$sizeName]->getSrcSizeImage();
                    $imageTempBackupPath = $tmpBackupDirImage . $imageSizes[$sizeName]->getName();
                    if (file_exists($originalPath)) {
                        copy($originalPath, $imageTempBackupPath);
                    }
                }
                $statusBySizes[$sizeName] = new StatusCUF();
                $statusBySizes[$sizeName]->setUsed(5); //5-> backup made
                $statusBySizes[$sizeName]->setInServer(5); //in backup folder
            }

        } else {
            foreach ($sizeNames as $sizeName) {
                $statusBySizes[$sizeName] = new StatusCUF();
                $statusBySizes[$sizeName]->setUsed(-5); //-5-> backup error
                $statusBySizes[$sizeName]->setInServer(-5); //in backup folder error

            }

        }

        echo json_encode($statusBySizes);
        wp_die();
    }

    public function restoreBackupById()
    {

        $json = json_decode(file_get_contents('php://input'), true);
        $backupId = $json['id'];

        if (!is_numeric($backupId)) {
            //nothing to do, this case is not possible but for security reason
            return;
        }

        $statusBackup = new StatusBackupCUF();

        $backupDir =$this->helpCUF->backupDir();
        $backFiles = $this->helpCUF->getFilesFromFolder($backupDir . '/' . $backupId . '/');
        $fileImages = preg_grep("/^(?!.*\\.backup)/", $backFiles);
        $fileBackup = preg_grep("/^(.*\\.backup)/", $backFiles);
        $fileBackupFile = $backupDir . '/' . $backupId . '/' . array_pop($fileBackup);

        $uploadDir = wp_upload_dir();
        $basedir = $uploadDir['basedir'];

        $backupInfo = unserialize(file_get_contents($fileBackupFile));
        foreach ($backupInfo["posts"] as $posts) {
            $this->databaseCUF->getDb()->replace($this->databaseCUF->getPrefix() . "posts", $posts);
        }
        foreach ($backupInfo["postMeta"] as $postMeta) {
            $this->databaseCUF->getDb()->replace($this->databaseCUF->getPrefix() . "postmeta", $postMeta);
        }

        foreach ($fileImages as $image) {
            if (!file_exists($basedir . '/' . $backupInfo["uploadDir"] . '/' . $image)) {
                if (file_exists($backupDir . '/' . $backupId . '/' . $image)) {
                    rename($backupDir . '/' . $backupId . '/' . $image, $basedir . '/' . $backupInfo["uploadDir"] . '/' . $image);
                }
            }

        }

        $statusBackup->setInServer(2); //2 -> in the upload folder
        echo json_encode($statusBackup);
        wp_die();
    }


    public function  makeBackupFolder()
    {
        $statusBackup = new StatusBackupCUF();
        $backupDir = $this->helpCUF->backupDir();
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
            if (!file_exists($backupDir)) {
                $statusBackup->setInServer(-3); //-3 -> can not be created
            } else {
                $statusBackup->setInServer(1); // 1 -> exists
            }
        }
        echo json_encode($statusBackup);
        wp_die();
    }

    public function  existsBackupFolder()
    {
        $statusBackup = new StatusBackupCUF();

        if ($this->helpCUF->backupFolderExist()) {
            $statusBackup->setInServer(1); // 1 -> exists
        } else {
            $statusBackup->setInServer(0); // 0 -> not exists
        }
        echo json_encode($statusBackup);
        wp_die();
    }


}

