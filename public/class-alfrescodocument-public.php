<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://majestic.com.au
 * @since      1.0.0
 *
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alfrescodocument
 * @subpackage Alfrescodocument/public
 * @author     ShibeLord HODL <nath@majestic.com.au>
 */
class Alfrescodocument_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alfrescodocument_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alfrescodocument_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/alfrescodocument-public.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Alfrescodocument_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Alfrescodocument_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/alfrescodocument-public.js', array('jquery'), $this->version, false);

	}

	function html_minify($html) {
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = false;
		$raw_tag = false;
		// Variable reused for output
		$html = '';
		foreach ($matches as $token) {
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;

			$content = $token[0];

			if (is_null($tag)) {
				if (!empty($token['script'])) {
					$strip = $this->compress_js;
				} else if (!empty($token['style'])) {
					$strip = $this->compress_css;
				} else if ($content == '<!--wp-html-compression no compression-->') {
					$overriding = !$overriding;

					// Don't print the comment
					continue;
				} else if ($this->remove_comments) {
					if (!$overriding && $raw_tag != 'textarea') {
						// Remove any HTML comments, except MSIE conditional comments
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			} else {
				if ($tag == 'pre' || $tag == 'textarea') {
					$raw_tag = $tag;
				} else if ($tag == '/pre' || $tag == '/textarea') {
					$raw_tag = false;
				} else {
					if ($raw_tag || $overriding) {
						$strip = false;
					} else {
						$strip = true;

						// Remove any empty attributes, except:
						// action, alt, content, src
						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);

						// Remove any space before the end of self-closing XHTML tags
						// JavaScript excluded
						$content = str_replace(' />', '/>', $content);
					}
				}
			}

			if ($strip) {
				$content = $this->removeWhiteSpace($content);
			}

			$html .= $content;
		}

		return $html;
	}

	protected function removeWhiteSpace($str) {
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n", '', $str);
		$str = str_replace("\r", '', $str);

		while (stristr($str, '  ')) {
			$str = str_replace('  ', ' ', $str);
		}

		return $str;
	}

	function register_shortcodes() {
		add_shortcode('alf-doc', array($this, 'alfresco_document'));
		add_shortcode('alf-doc-preview', array($this, 'alfresco_document_preview'));
		add_shortcode('alf-doc-title', array($this, 'alfresco_document_title'));
		add_shortcode('alf-doc-description', array($this, 'alfresco_document_description'));
		add_shortcode('alf-doc-link', array($this, 'alfresco_document_link'));
	}

	public function alfresco_document($atts) {
		$pull_quote_atts = shortcode_atts(array(
			'path' => '',
		), $atts);
		if (strlen($pull_quote_atts['path']) > 0) {
			$docList = $this->getDocList(
				get_option($this->plugin_name . '_url'),
				get_option($this->plugin_name . '_port'),
				get_option($this->plugin_name . '_username'),
				get_option($this->plugin_name . '_password'),
				$pull_quote_atts['path']);
		} else {
			$docList = $this->getDocList(
				get_option($this->plugin_name . '_url'),
				get_option($this->plugin_name . '_port'),
				get_option($this->plugin_name . '_username'),
				get_option($this->plugin_name . '_password'),
				get_option($this->plugin_name . '_folder'));
		}

//        $ticket = $this->getAlfTicket(
		//                        get_option( $this->plugin_name . '_url' ),
		//                        get_option( $this->plugin_name . '_port' ),
		//                        get_option( $this->plugin_name . '_username' ),
		//                        get_option( $this->plugin_name . '_password' ));

		return $this->documentRender($docList);
	}

	public function alfresco_document_preview($atts) {
		$pull_quote_atts = shortcode_atts(array(
			'path' => '',
		), $atts);

		$path = "";
		if (strlen($_GET['path']) > 0) {
			$path = $_GET['path'];
		}
		if (strlen($pull_quote_atts['path']) > 0) {
			$path = $pull_quote_atts['path'];
		}
		return '<iframe class="gde-frame" style="width: 100%; height: 700px; border: none;" src="//docs.google.com/viewer?url=http%3A%2F%2Falfresco5.majestic.com.au%2Fintranet%2Fpdfjs%2Fweb%2Freview.php%3Falfpath%3D'
			. $path . '&amp;hl=en_US&amp;embedded=true" width="300" height="150" scrolling="no"></iframe>';
	}

	public function alfresco_document_title($atts) {
		if (strlen($_GET['t']) > 0) {
			$title = $_GET['t'];
		}
		return $title;
	}

	public function alfresco_document_description($atts) {
		if (strlen($_GET['d']) > 0) {
			$description = $_GET['d'];
		}
		return $description;
	}

	public function alfresco_document_link($atts) {
		if (strlen($_GET['path']) > 0 && strlen($_GET['ty']) > 0) {
			$path = $_GET['path'];
			$fileType = $_GET['ty'];

			$alfTicket = $this->getAlfTicket(
				get_option($this->plugin_name . '_url'),
				get_option($this->plugin_name . '_port'),
				get_option($this->plugin_name . '_username'),
				get_option($this->plugin_name . '_password'));
			$downloadLink = "";
			if ($fileType === "cmis:folder") {
				$downloadLink = get_option($this->plugin_name . '_url') . ":" . get_option($this->plugin_name . '_port') . "/share/page/context/shared/folder-details?nodeRef=workspace://SpacesStore/" . $path;
			} else {
				$downloadLink = get_option($this->plugin_name . '_url') . ':' . get_option($this->plugin_name . '_port') . '/alfresco/service/api/node/content/workspace/SpacesStore/' . $path . '/?a=true&amp;alf_ticket=' . $alfTicket;
			}
			return $downloadLink;
		} else {
			return "";
		}

	}

	function getDocList($url, $port, $userName, $password, $path) {

		$docList = array();
		$repoObject = new CMISalfObject($url . ":" . $port . "/alfresco/cmisatom", $userName, $password, $path);
		$repoObject->listContent();
		for ($i = 0; $i < count($repoObject->containedObjects); $i++) {
			$docObject = new stdClass();
			$docObject->fileType = $repoObject->containedObjects[$i]->properties['cmis:objectTypeId'];
			$docObject->fileName = $repoObject->containedObjects[$i]->properties['cmis:name'];
			$docObject->title = $repoObject->containedObjects[$i]->aspects['cm:title'];
			$docObject->description = $repoObject->containedObjects[$i]->aspects['cm:description'];
			$docObject->path = str_replace("workspace://SpacesStore/", "", $repoObject->containedObjects[$i]->properties['alfcmis:nodeRef']);
			$docObject->thumbnail = $repoObject->containedObjects[$i]->thumbnailUrl;
			$docObject->id = str_replace("workspace://SpacesStore/", "", $repoObject->containedObjects[$i]->properties['alfcmis:nodeRef']);
			array_push($docList, $docObject);
		}
		return $docList;
	}

	//get Alfresco ticket
	//should I show alfresco ticket in thumbnail????
	private function getAlfTicket($url, $port, $userName, $password) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url . ":" . $port . "/alfresco/service/api/login?u=" . $userName . "&pw=" . $password);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// execute the request
		$output = curl_exec($ch);

		$xml = new DOMDocument;
		$xml->loadXML($output);
		$ticket = $xml->getElementsByTagName('ticket')->item(0)->nodeValue;
		return $ticket;
	}

	//render document info in HTML
	private function documentRender($docList) {
		$alfTicket = $this->getAlfTicket(
			get_option($this->plugin_name . '_url'),
			get_option($this->plugin_name . '_port'),
			get_option($this->plugin_name . '_username'),
			get_option($this->plugin_name . '_password'));

		$genPath = get_option($this->plugin_name . '_url') . get_option($this->plugin_name . '_port') . "/share/proxy/alfresco/api/node/workspace/SpacesStore/";
		$options = get_option($this->plugin_name . '_display');
		$render = "<div class='alf'>";
		foreach ($docList as $doc) {
			if ($doc->fileType === "cmis:folder") {

			} else {
				$render .= "<div class='alf__doc'>";
				// set a download link
				$downloadLink = "";
				if ($doc->fileType === "cmis:folder") {
					$downloadLink = get_option($this->plugin_name . '_url') . ":" . get_option($this->plugin_name . '_port') . "/share/page/context/shared/folder-details?nodeRef=workspace://SpacesStore/" . $doc->path;
				} else {
					$downloadLink = get_option($this->plugin_name . '_url') . ':' . get_option($this->plugin_name . '_port') . '/alfresco/service/api/node/content/workspace/SpacesStore/' . $doc->path . '/?a=true&amp;alf_ticket=' . $alfTicket;
				}
				//force send to preview page
				$downloadLink = "/mais/preview/?path=" . $doc->path . "&t=" . $doc->title . "&d=" . $doc->description . "&ty=" . $doc->fileType;
				// check show thumbnail
				if (isset($options[thumbnail])) {
					$render .= "<div class='alf__image'>";
					// check if it is folder
					if ($doc->fileType === "cmis:folder") {
						$render .= isset($options[download]) ? "<a href='" . $downloadLink . "' target='_blank'>" : "";
						$render .= "<img src='" . get_option($this->plugin_name . '_url') . ":" . get_option($this->plugin_name . '_port') . "/share/res/components/documentlibrary/images/folder-64.png' alt='" . (isset($options[title]) ? $doc->title : "") . "'> </a>";
						$render .= isset($options[download]) ? "</a>" : "";
					} else {
						if ($doc->thumbnail != '') {
							$render .= (isset($options[download]) ? '<a href="' . get_option($this->plugin_name . '_url') . ':' . get_option($this->plugin_name . '_port') . '/alfresco/service/api/node/content/workspace/SpacesStore/' . $doc->path . '/?a=true&amp;alf_ticket=' . $alfTicket . '">' : "") . "<img src='" . $doc->thumbnail . "&ticket=" . $alfTicket . "' alt='" . (isset($options[title]) ? $doc->title : "") . "'>" . "</a>";
						} else {
							$render .= "<img src='" . $genPath . '' . $doc->path . "/content/thumbnails/doclib?c=queue&ph=true' alt='" . (isset($options[title]) ? $doc->title : "") . "'>";
						}
					}
					$render .= "</div>";
				}

				$render .= "<div class='alf__docInfo'><h3>" . (isset($options[download]) ? '<a href="' . $downloadLink . '">' : "") .

					(isset($options[title]) ?
					(isset($doc->title) ?
						$doc->title :
						(isset($options[name]) ?
							$doc->fileName :
							""
						)
					) :

					(isset($options[name]) ?
						$doc->fileName :
						(isset($options[title]) ?
							$doc->title :
							""
						)
					)

				) . (isset($options[download]) ? "</a>" : "") . "</h3><i>" . (isset($options[title]) ? (isset($options[name]) ? $doc->fileName : "") : "") . "</i><i>" . (isset($options[path]) ? $doc->path : "") . "</i><p>" . (isset($options[description]) ? $doc->description : "") . "</p></div></div>";
			}

		}
		$render .= "</div>";

		return $render;
	}

}