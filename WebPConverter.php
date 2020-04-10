<?php

class WebPConverter
{
    /**
     * @var string $imagePath
     */
    private $imagePath = null;

    /**
     * @var int $imageQuality
     */
    private $imageQuality = 100;

    /**
     * @var string $image
     */
    private $image = null;

    /**
     * Set image for converting
     *
     * @param string $imagePath
     * @param int $imageQuality
     */
    public function setImage($imagePath, $imageQuality = 100)
    {
        $this->imagePath = $imagePath;
        $this->imageQuality = $imageQuality;
    }

    /**
     * Run converting image to webP format
     */
    public function runConverting()
    {
        $this->converting();
    }

    /**
     * Get new converted image
     */
    public function getImage()
    {
        header('Content-Type: image/webp');

        imagewebp($this->image, null, $this->imageQuality);
    }

    /**
     * Save new converted image
     *
     * @param string $path
     * @param string $name
     */
    public function saveImage($path, $name)
    {
        header('Content-Type: image/webp');

        imagewebp($this->image, $path . $name, $this->imageQuality);
    }

    /**
     * Converting image to webP format
     */
    private function converting()
    {
        $this->image = $this->createImageObject($this->imagePath);
        $this->setImageOptions();
    }

    /**
     * Set options for image
     * Use GD library
     */
    private function setImageOptions()
    {
        $textColor = imagecolorallocate($this->image, 233, 14, 91);
        imagestring($this->image, 1, 5, 5,  '', $textColor);
    }

    /**
     * Create image object for file
     *
     * @param string $filename
     * @return false|resource
     */
    private function createImageObject($filename) {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException('File "' . $filename . '" not found.');
        }
        switch (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($filename);
                break;

            case 'png':
                return imagecreatefrompng($filename);
                break;

            case 'gif':
                return imagecreatefromgif($filename);
                break;

            default:
                throw new InvalidArgumentException('File "' . $filename . '" is not valid jpg, png or gif image.');
                break;
        }
    }

    /**
     * Clear object
     */
    public function __destruct()
    {
        imagedestroy($this->image);
    }
}
