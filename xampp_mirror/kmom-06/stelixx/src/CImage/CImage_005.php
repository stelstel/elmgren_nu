<?php 
/**
 * This is a PHP skript to process images using PHP GD.
 *
 */
class CImage {
	
	private $src, $verbose, $saveAs, $quality, $quality_, $pathToImage;
	private $ignoreCache, $width, $height, $newWidth, $newHeight, $cropToFit, $cropToFit_, $sharpen, $sharpen_;
	private $type, $attr, $image, $cacheFileName, $maxWidth, $maxHeight;
	
	// ******************************** Constructor ************************
	public function __construct($request) {
		$this->init();
		$this->getInput($request);
		$this->validateInput();
		$this->verb();
		$this->getImgInfo();
		$this->calcNewDims();
		$this->createFileName();
		$this->resize();
		$this->filters();
		$this->saveImg();
	}
	
	private function init(){
		// Ensure error reporting is on
		error_reporting(-1);              // Report all type of errors
		ini_set('display_errors', 1);     // Display all errors 
		ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
		
		// Define some constant values, append slash
		// Use DIRECTORY_SEPARATOR to make it work on both windows and unix.
		define('IMG_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '../../webroot/img/cimage') . DIRECTORY_SEPARATOR );
		define('CACHE_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '../../webroot/img/cimage/cache') . DIRECTORY_SEPARATOR);
		//define('CACHE_PATH', __DIR__ . '/cache/');
		$this->maxWidth = $this->maxHeight = 2000;	
	}
	
	private function getInput($req){
		// Get the incoming arguments
		$this->src         = isset($req['src'])     ? $req['src']      : null;
		$this->verbose     = isset($req['verbose']) ? true              : null;
		$this->saveAs      = isset($req['save-as']) ? $req['save-as']  : null;
		$this->quality     = isset($req['quality']) ? $req['quality']  : 60;
		$this->ignoreCache = isset($req['no-cache']) ? true           : null;
		$this->newWidth    = isset($req['width'])   ? $req['width']    : null;
		$this->newHeight   = isset($req['height'])  ? $req['height']   : null;
		$this->cropToFit   = isset($req['crop-to-fit']) ? true : null;
		$this->sharpen     = isset($req['sharpen']) ? true : null;
		
		$this->pathToImage = IMG_PATH . $this->src;
	}
	
	private function validateInput(){
		//
		// Validate incoming arguments
		//echo "<br>IMG_PATH: " . IMG_PATH; ////////////////////////////////////////////////////////////
		//echo "<br>pathToIm: " . $this->pathToImage;
		//echo "<br>CACHE_PATH: " . CACHE_PATH; ////////////////////////////////////////////////////////////
		
		is_dir(IMG_PATH) or $this->errorMessage('The image dir is not a valid directory.');
		is_writable(CACHE_PATH) or $this->errorMessage('The cache dir is not a writable directory.');
		isset($this->src) or $this->errorMessage('Must set src-attribute.');
		preg_match('#^[a-z0-9A-Z-_\.\/]+$#', $this->src) or errorMessage('Filename contains invalid characters.');
		substr_compare(IMG_PATH, $this->pathToImage, 0, strlen(IMG_PATH) ) == 0 or $this->errorMessage('Security constraint: Source image is not directly below the directory IMG_PATH.');
		is_null($this->saveAs) or in_array($this->saveAs, array('png', 'jpg', 'jpeg')) or errorMessage('Not a valid extension to save image as');
		is_null($this->quality) or (is_numeric($this->quality) and $this->quality > 0 and $this->quality <= 100) or errorMessage('Quality out of range');
		is_null($this->newWidth) or (is_numeric($this->newWidth) and $this->newWidth > 0 and $this->newWidth <= $this->maxWidth) or errorMessage('Width out of range');
		is_null($this->newHeight) or (is_numeric($this->newHeight) and $this->newHeight > 0 and $this->newHeight <= $this->maxHeight) or errorMessage('Height out of range');
		is_null($this->cropToFit) or ($this->cropToFit and $this->newWidth and $this->newHeight) or errorMessage('Crop to fit needs both width and height to work');
	}
		
	/**
	 * Display error message.
	 *
	 * @param string $message the error message to display.
	 */
	function errorMessage($message) {
		header("Status: 404 Not Found");
		die('CImage.php says 404 - ' . htmlentities($message));
	}
		
	/**
	 * Display log message.
	 *
	 * @param string $message the log message to display.
	 */
	function verbose($message) {
		echo "<p>" . htmlentities($message) . "</p>";
	}
		
	/**
	 * Output an image together with last modified header.
	 *
	 * @param string $file as path to the image.
	 * @param boolean $verbose if verbose mode is on or off.
	 */
	function outputImage($file, $verbose) {
		$info = getimagesize($file);
		echo "<br>info: " . dump($info); //////////////////////////////////////////////////////////
		!empty($info) or $this->errorMessage("The file doesn't seem to be an image.");
		$mime   = $info['mime'];
	
		$lastModified = filemtime($file);  
		$gmdate = gmdate("D, d M Y H:i:s", $lastModified);
	
		if($verbose) {
			verbose("Memory peak: " . round(memory_get_peak_usage() /1024/1024) . "M");
			verbose("Memory limit: " . ini_get('memory_limit'));
			verbose("Time is {$gmdate} GMT.");
		}
	
		if(!$verbose) header('Last-Modified: ' . $gmdate . ' GMT');
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified){
			if($verbose) { verbose("Would send header 304 Not Modified, but its verbose mode."); exit; }
			header('HTTP/1.0 304 Not Modified');
		} else {  
			if($verbose) { verbose("Would send header to deliver image with modified time: {$gmdate} GMT, but its verbose mode."); exit; }
			header('Content-type: ' . $mime);  
			readfile($file);
		}
		exit;
	}
		
	/**
	 * Sharpen image as http://php.net/manual/en/ref.image.php#56144
	 * http://loriweb.pair.com/8udf-sharpen.html
	 *
	 * @param resource $image the image to apply this filter on.
	 * @return resource $image as the processed image.
	 */
	function sharpenImage($image) {
		$matrix = array(
			array(-1,-1,-1,),
			array(-1,16,-1,),
			array(-1,-1,-1,)
		);
		$divisor = 8;
		$offset = 0;
		imageconvolution($image, $matrix, $divisor, $offset);
		return $image;
	}

	private function verb(){	
		//
		// Start displaying log if verbose mode & create url to current image
		//
		if($this->verbose) {
			$query = array();
			parse_str($_SERVER['QUERY_STRING'], $query);
			unset($query['verbose']);
			$url = '?' . http_build_query($query);
			
			echo <<<EOD
				<html lang='en'>
				<meta charset='UTF-8'/>
				<title>img.php verbose mode</title>
				<h1>Verbose mode</h1>
				<p><a href=$url><code>$url</code></a><br>
				<img src='{$url}' /></p>
EOD;
		}
	}
	
	private function getImgInfo(){	
		// Get information on the image
		
		$imgInfo = list($this->width, $this->height, $this->type, $this->attr) = getimagesize($this->pathToImage);
		!empty($imgInfo) or errorMessage("The file doesn't seem to be an image.");
		$mime = $imgInfo['mime'];
		
		if($this->verbose) {
			$filesize = filesize($this->pathToImage);
			verbose("Image file: {$pathToImage}");
			verbose("Image information: " . print_r($imgInfo, true));
			verbose("Image width x height (type): {$this->width} x {$this->height} ({$type}).");
			verbose("Image file size: {$filesize} bytes.");
			verbose("Image mime type: {$mime}.");
		}
	}
	
	private function calcNewDims(){	
		// Calculate new width and height for the image
		echo "<br>width" . $this->width; /////////////////////////////////////////////////////
		echo "<br>NEW width" . $this->newWidth; /////////////////////////////////////////////////////
		$aspectRatio = $this->width / $this->height;
		
		if($this->cropToFit && $this->newWidth && $this->newHeight) {
			$targetRatio = $this->newWidth / $this->newHeight;
			$cropWidth   = $targetRatio > $aspectRatio ? $this->width : round($this->height * $targetRatio);
			$cropHeight  = $targetRatio > $aspectRatio ? round($this->width  / $targetRatio) : $this->height;
			if($this->verbose) { verbose("Crop to fit into box of {$this->newWidth}x{$this->newHeight}. Cropping dimensions: {$cropWidth}x{$cropHeight}."); }
		}
		else if($this->newWidth && !$this->newHeight) {
			$this->newHeight = round($this->newWidth / $aspectRatio);
			if($this->verbose) { verbose("New width is known {$this->newWidth}, height is calculated to {$this->newHeight}."); }
		}
		else if(!$this->newWidth && $this->newHeight) {
			$this->newWidth = round($this->newHeight * $aspectRatio);
			if($this->verbose) { verbose("New height is known {$this->newHeight}, width is calculated to {$this->newWidth}."); }
		}
		else if($this->newWidth && $this->newHeight) {
			$ratioWidth  = $this->width  / $this->newWidth;
			$ratioHeight = $this->height / $this->newHeight;
			$ratio = ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
			$this->newWidth  = round($this->width  / $ratio);
			$this->newHeight = round($this->height / $ratio);
			if($verbose) { verbose("New width & height is requested, keeping aspect ratio results in {$this->newWidth}x{$this->newHeight}."); }
		}
		else {
			$this->newWidth = $this->width;
			$this->newHeight = $this->height;
			if($this->verbose) { verbose("Keeping original width & heigth."); }
		}
	}
	
	private function createFileName(){	
		// Creating a filename for the cache
		
		$parts          = pathinfo($this->pathToImage);
		$fileExtension  = $parts['extension'];
		$this->saveAs         = is_null($this->saveAs) ? $fileExtension : $this->saveAs;
		$quality_       = is_null($this->quality) ? null : "_q{$this->quality}";
		$cropToFit_     = is_null($this->cropToFit) ? null : "_cf";
		$sharpen_       = is_null($this->sharpen) ? null : "_s";
		$dirName        = preg_replace('/\//', '-', dirname($this->src));
		//$this->cacheFileName = CACHE_PATH . "-{$dirName}-{$parts['filename']}_{$this->newWidth}_{$this->newHeight}{$this->quality_}{$this->cropToFit_}{$this->sharpen_}.{$this->saveAs}";
		$this->cacheFileName = CACHE_PATH . "-{$dirName}-{$parts['filename']}_{$this->newWidth}_{$this->newHeight}{$this->quality_}{$this->cropToFit_}{$this->sharpen_}.{$this->saveAs}";
		echo "<br>THIS_CACHEFILENAME: " . $this->cacheFileName; //////////////////////////////////////
		$this->cacheFileName = preg_replace('/^a-zA-Z0-9\.-_/', '', $this->cacheFileName);
		
		if($this->verbose) { verbose("Cache file is: {$this->cacheFileName}"); }
			
		// Is there already a valid image in the cache directory, then use it and exit
		$imageModifiedTime = filemtime($this->pathToImage);
		$cacheModifiedTime = is_file($this->cacheFileName) ? filemtime($this->cacheFileName) : null;
		
		// If cached image is valid, output it.
		if(!$this->ignoreCache && is_file($this->cacheFileName) && $imageModifiedTime < $cacheModifiedTime) {
			if($this->verbose) { verbose("Cache file is valid, output it."); }
			$this->outputImage($this->cacheFileName, $this->verbose);
		}
		
		if($this->verbose) { verbose("Cache is not valid, process image and create a cached version of it."); }
			
		// Open up the original image from file
		if($this->verbose) { verbose("File extension is: {$fileExtension}"); }
		
		switch($fileExtension) {  
			case 'jpg':
			case 'jpeg': 
				$this->image = imagecreatefromjpeg($this->pathToImage);
				if($this->verbose) { verbose("Opened the image as a JPEG image."); }
				break;  
			
			case 'png':  
				$this->image = imagecreatefrompng($this->pathToImage); 
				if($this->verbose) { verbose("Opened the image as a PNG image."); }
				break;  
		
			default: errorPage('No support for this file extension.');
		}
	}
	
	private function resize(){
		
		// Resize the image if needed
		if($this->cropToFit) {
			if($this->verbose) { verbose("Resizing, crop to fit."); }
			$cropX = round(($this->width - $cropWidth) / 2);  
			$cropY = round(($this->height - $cropHeight) / 2);    
			$imageResized = imagecreatetruecolor($this->newWidth, $this->newHeight);
			imagecopyresampled($imageResized, $this->image, 0, 0, $cropX, $cropY, $this->newWidth, $this->newHeight, $cropWidth, $cropHeight);
			$this->image = $imageResized;
			$this->width = $this->newWidth;
			$this->height = $this->newHeight;
		}
		else if(!($this->newWidth == $this->width && $this->newHeight == $this->height)) {
			if($this->verbose) { vgerbose("Resizing, new height and/or width."); }
			$imageResized = imagecreatetruecolor($this->newWidth, $this->newHeight);
			imagecopyresampled($imageResized, $this->image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
			$image  = $imageResized;
			$this->width  = $this->newWidth;
			$this->height = $this->newHeight;
		}
	}
		
	private function filters(){
		// Apply filters and postprocessing of image
		//
		if($this->sharpen) {
			$image = sharpenImage($image);
		}
	}
	
	private function saveImg(){	
		// Save the image
		
		switch($this->saveAs) {
			case 'jpeg':
			case 'jpg':
				if($verbose) { verbose("Saving image as JPEG to cache using quality = {$this->quality}."); }
				imagejpeg($this->image, $this->cacheFileName, $this->quality);
			break;  
		
			case 'png':  
				if($this->verbose) { verbose("Saving image as PNG to cache."); }
				imagepng($this->image, $this->cacheFileName);  
			break;  
		
			default:
				errorMessage('No support to save as this file extension.');
			break;
		}
		
		if($this->verbose) { 
			clearstatcache();
			$cacheFilesize = filesize($this->cacheFileName);
			verbose("File size of cached file: {$cacheFilesize} bytes."); 
			verbose("Cache file has a file size of " . round($cacheFilesize/$filesize*100) . "% of the original size.");
		}
	}
		
	public function getImage(){
		// Output the resulting image
	
		$this->outputImage($this->cacheFileName, $this->verbose);
	}
}