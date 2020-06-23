<?php
include ("../webroot/filter.php");
/**
 * Content
 *
 */
class CContent {

  /**
   * Member Variables
   */
  private $dBase;		// Database
	private $editPag;
	private $pagePag;
	private $blogPag;
	private $validFilters = array( 
  	'bbcode',
    'link',
    'markdown',
    'nl2br',  
  );						
  
  /**
   * Constructor 
   *
   * @param  $db database
   *
   */
  public function __construct($db) {
  	$this->dBase = $db;
		$this->editPag = "edit.php";
		$this->pagePag = "page.php";
		$this->blogPag = "blog.php";
		$this->createContentTable();
  }
	
	//***************************************************************************************************
	public function showAll(){
		$output =<<<EOD
		<h1>Visa allt innehåll</h1>
		<p>Här är en lista på allt innehåll i databasen.</p>
EOD;
		$sql = "SELECT *, (published <= NOW()) AS available	FROM content";
		$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);
		$output .= "<ul>";
		
		foreach($result AS $key=>$val){
			if( !( ($val->TYPE == "page") OR ($val->TYPE == "post") ) ){ // Check if value is legal
				die('Check: TYPE must be page or post.');		
			}else{
				$TYPE = htmlentities($val->TYPE, null, 'UTF-8'); //Sanitizing			
			}
			
			$title = htmlentities($val->title, null, 'UTF-8'); //Sanitizing			
			
			$output .= '<li>' . $TYPE . ' (publicerad): '	. $title; 
			
			if(!is_numeric($val->id)){ // Check if value is legal	
				die('Check: id must be numeric.');	
			}else{
				$id = htmlentities($val->id, null, 'UTF-8'); //Sanitizing				
			}
						
			$output .= ' (<a href="' . $this->editPag . '?id=' . $id . '">editera</a>';
			$output .= ' <a href="';
			
			$slug = htmlentities($val->slug, null, 'UTF-8'); //Sanitizing				
			
			if($TYPE == "page"){
				$output .= $this->pagePag . '?url=' . $slug;
			}else if($TYPE == "post"){
				$output .= $this->blogPag . '?slug=' . $slug;
			}
			$output .= '">visa</a>)</li>';
		}
		$output .= "</ul>";
		$output .= "<p><a href='blog.php'>Visa alla bloggposter</a></p>";
	return $output;
	}
	
	//***************************************************************************************************
	public function show($request, $part){
		$pageOrBlog = substr($part, 0, 4);
						
		if($pageOrBlog == "page"){
			if(isset($request["url"]) ){
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE url='" . $request["url"] . "'";
			}else{
				die('Check: Page without URL');	
			}
		}else if($pageOrBlog == "blog"){ 
			if(isset($request["slug"]) ){
				$slug = $request["slug"];
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE slug='" . $slug . "'"; //Show one blog
			}else{
				$sql = "SELECT *, (published <= NOW()) AS available	FROM content WHERE TYPE='post'"; //Show all blogs
			}
		}else{
			die('Check: Neither page or blog');
		}
		
		if(isset($sql)){
			$result = $this->dBase->ExecuteSelectQueryAndFetchAll($sql);		
		}
		
		if(isset($result[0]->title)){
			$title = htmlentities($result[0]->title, null, 'UTF-8'); //Sanitizing
		}
		
		if(isset($result[0]->DATA) ){
			$data = htmlentities($result[0]->DATA, null, 'UTF-8'); //Sanitizing
		}
		
		if(isset($result[0]->FILTER) ){
			$FILTER = htmlentities($result[0]->FILTER, null, 'UTF-8'); //Sanitizing
			$arrFilters = explode(",",$FILTER );
			foreach($arrFilters AS $af){
				if(!in_array($af,$this->validFilters)){
					die('Check: Invalid FILTER: ' . $FILTER);			
				}
			}
			$filter = $result[0]->FILTER;
		}
		
		if($part == "pageTitle" OR $part == "blogTitle"){
			if($title){
				return $title;
			}
		}else	if($part == "pageMain"){
			if($title){
				$output = "<H1>" . $title . "</H1>";
				$output .= doFilter($data, $result[0]->FILTER);
			}
			return $output;
		}else	if($part == "blogMain"){
			return $this->showBlog($result);
		}
	}
	
	//*******************************************************************
	private function showBlog($res){
		//dump($res); ///////////////////////////////////////////////////////////////////////////
		$output = "";
		
		foreach($res AS $r){
			if(isset($r->slug)){
				$slug = htmlentities($r->slug, null, 'UTF-8'); //Sanitizing
			}
			
			if(isset($r->title)){
				$title = htmlentities($r->title, null, 'UTF-8'); //Sanitizing
			}
			
			if(isset($r->FILTER)){
				$FILTER = htmlentities($r->FILTER, null, 'UTF-8'); //Sanitizing
				$arrFilters = explode(",",$FILTER );
				foreach($arrFilters AS $af){
					if(!in_array($af,$this->validFilters)){
						die('Check: Invalid FILTER: ' . $FILTER);			
					}
				}
				$filter = $r->FILTER;
			}
			
			if(isset($r->DATA) ){
				$data = htmlentities($r->DATA, null, 'UTF-8'); //Sanitizing
			}
							
			$output .= '<H1><a href="?slug=' . $slug . '">' . $title . "</a></H1>";
			if(isset($filter)){
				$output .= doFilter($data, $filter);			
			}else{
				$output .= $data;			
			}
		}
		return $output;
	}
	
	//*********************************************************************************************
	private function createContentTable(){
		$sql = <<<EOD
			/*CREATE DATABASE  IF NOT EXISTS `kmom05` /*!40100 DEFAULT CHARACTER SET latin1 ;
			USE `kmom05`;
			-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
			--
			-- Host: 127.0.0.1    Database: kmom05
			-- ------------------------------------------------------
			-- Server version	5.6.16*/
			
			/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
			/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
			/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
			/*!40101 SET NAMES utf8 */;
			/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
			/*!40103 SET TIME_ZONE='+00:00' */;
			/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
			/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
			/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
			/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
			
			--
			-- Table structure for table `content`
			--
			
			DROP TABLE IF EXISTS `content`;
			/*!40101 SET @saved_cs_client     = @@character_set_client */;
			/*!40101 SET character_set_client = utf8 */;
			CREATE TABLE `content` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`slug` char(80) DEFAULT NULL,
				`url` char(80) DEFAULT NULL,
				`TYPE` char(80) DEFAULT NULL,
				`title` varchar(80) DEFAULT NULL,
				`DATA` text,
				`FILTER` char(80) DEFAULT NULL,
				`published` datetime DEFAULT NULL,
				`created` datetime DEFAULT NULL,
				`updated` datetime DEFAULT NULL,
				`deleted` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `slug` (`slug`),
				UNIQUE KEY `url` (`url`)
			) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
			/*!40101 SET character_set_client = @saved_cs_client */;
			
			--
			-- Dumping data for table `content`
			--
			
			LOCK TABLES `content` WRITE;
			/*!40000 ALTER TABLE `content` DISABLE KEYS */;
			INSERT INTO `content` VALUES (1,'hem','hem','page','Hem','Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter \'nl2br\' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.','bbcode,nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL),(2,'om','om','page','Om','Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.','markdown','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL),(3,'blogpost-1',NULL,'post','Välkommen till min blogg!','Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.','link,nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL),(4,'blogpost-2',NULL,'post','Nu har sommaren kommit','Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.','nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL),(5,'blogpost-3',NULL,'post','Nu har hösten kommit','Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost','nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL),(6,'blogpost-4',NULL,'post','Stefan bloggar','Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg.',NULL,'2014-11-08 23:22:15','2014-11-08 23:22:14',NULL,NULL);
			UNLOCK TABLES;
			
			/*--
			-- Dumping events for database 'kmom05'
			--
			/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
			
			/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
			/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
			/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
			/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
			/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
			/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
			/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;*/
			
			/*-- Dump completed on 2014-11-09  1:21:26*/
			
EOD;
		$this->dBase->ExecuteSelectQueryAndFetchAll($sql);
	}
}