<?php

class TDProject_Core_Controller_Helper_Upload {

    private $allowedExtensions = array();
    private $sizeLimit = 52428800;
    private $file;

    protected $_targetFilename = '';

    public function __construct()
    {

        if (isset($_GET['qqfile'])) {
            $this->file = new TDProject_Core_Controller_Helper_Upload_Xhr();
        }
        elseif (isset($_FILES['qqfile'])) {
            $this->file = new TDProject_Core_Controller_Helper_Upload_File();
        }
        else {
            $this->file = false;
        }
    }

    /**
     * Returns the name of the uploaded file.
     *
     * @return string The name of the uploaded file
     */
    public function getFilename()
    {
        return $this->file->getName();
    }

    /**
     * Returns the size of the uploaded file.
     *
     * @return integer The size of the uploaded file
     */
    public function getFilesize()
    {
        return $this->file->getSize();
    }

    public function setAllowedExtension(array $allowedExtensions)
    {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
        $this->allowedExtensions = $allowedExtensions;
        return $this;
    }

    public function setSizeLimit($sizeLimit)
    {
        $this->sizeLimit = $sizeLimit;
        return $this;
    }

    /**
     * Check's post_max_size and upload_max_filesize settings in php.ini 
     * file to be at least the same or higher then the value set by 
     * calling setSizeLimit() method.
     * 
     * @throws Exception Is thrown if on of the values is lower
     * @return TDProject_Core_Controller_Helper_Upload The instance itself
     */
    public function checkServerSettings()
    {
    	
    	// load ini values
        $postSize = $this->toBytes(get_cfg_var('post_max_size'));
        $uploadSize = $this->toBytes(get_cfg_var('upload_max_filesize'));

        // check values
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            throw new Exception("Increase post_max_size ($postSize) and upload_max_filesize ($uploadSize) to $size");
        }

        // return the instance
        return $this;
    }

    public function toBytes($str)
    {
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    public function setTargetFilename($targetFilename)
    {
    	return $this->_targetFilename = $targetFilename;
    }

    public function getTargetFilename()
    {
    	return $this->_targetFilename;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    public function handleUpload($uploadDirectory, $replaceOldFile = false)
    {
        if (!is_writable($uploadDirectory)) {
            throw new Exception("Server error. Upload directory isn't writable.");
        }
        if (!$this->file) {
            throw new Exception('No files were uploaded.');
        }
        $size = $this->file->getSize();
        if ($size == 0) {
            throw new Exception('File is empty');
        }

        if ($size > $this->sizeLimit) {
            throw new Exception("File size $size KB is too large (max allowed KB: {$this->sizeLimit})");
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];
        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            throw new Exception("File has an invalid extension, it should be one of $these.");
        }

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        $targetFilename = $uploadDirectory . $filename . '.' . $ext;
        if ($this->file->save($targetFilename)) {
            return $targetFilename;
        }
        else {
            throw new Excpetion(
            	'Could not save uploaded file. The upload was cancelled, or server error encountered'
            );
        }
    }
}