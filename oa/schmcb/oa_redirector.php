<?php
	header("Content-Type: text/html;charset=UTF-8");
	//session_start();
	//echo '<script>';
	//echo 'console.log("test1")';

	$eUrl = NULL;
	$dUrl = NULL;

	//echo $_REQUEST["url"]."<br>";
	//exit;

	if (!$_REQUEST["url"]) {
		
		echo '<script>';
		echo 'alert("해당 전자자원의 접속 정보가 없습니다!\n 도서관에 문의해주세요.");';
		echo 'location.replace("https://lib.bucheon.schmc.ac.kr/");';
		echo '</script>';
		exit;
	}

	if (strpos($_REQUEST['url'], "go.openathens.net")) {
		//echo $_REQUEST["url"];
		$dUrl = urldecode($_REQUEST["url"]);
		//echo $dUrl."<br>";		
		//echo substr($dUrl, strpos($dUrl, "url=")+4)."<br>";		
		$eUrl = urlencode(substr($dUrl, strpos($dUrl, "url=")+4));
		//echo "https://go.openathens.net/redirector/bucheon.schmc.ac.kr?url=".$eUrl."<br>";
		//exit;
		header("Location: "."https://go.openathens.net/redirector/bucheon.schmc.ac.kr?url=".$eUrl);
		exit;		
	}
	
	//exit;
	// tarREQUESTUrl 별 athenized url 처리
	// OpenAthens 비적용 전자자원
	if (strpos($_REQUEST['url'], "apis.ebsco.com") 
		|| strpos($_REQUEST['url'], "research.ebsco.com") 		
		|| strpos($_REQUEST['url'], "gssapps.ebscohost.com") 
		|| strpos($_REQUEST['url'], "bucheon.schmc.ac.kr") 
		|| strpos($_REQUEST['url'], "kmbase.medric.or.kr")  	// KMBase (한국의학논문데이터베이스)
		|| strpos($_REQUEST['url'], "koreamed.org") 			// KoreaMed
		|| strpos($_REQUEST['url'], "nanet.go.kr") 				// 국회도서관
		|| strpos($_REQUEST['url'], "koreascience.kr") 			// KoreaScience (KISTI)
		|| strpos($_REQUEST['url'], "accesson.kr") 				// AccessOn (KISTI)
		|| strpos($_REQUEST['url'], "riss.kr") 					// RISS (KERIS)
		|| strpos($_REQUEST['url'], "pubmed") 					// PubMed		
		|| strpos($_REQUEST['url'], "kci.go.kr")				// KCI (한국연구재단)
		|| strpos($_REQUEST['url'], "embase.com")				// EMBASE 
		|| strpos($_REQUEST['url'], "schackr.turnitin.com") 	// iThenticate
		|| strpos($_REQUEST['url'], "micromedexsolutions.com")	// MicorMedex
		|| strpos($_REQUEST['url'], "kisti.re.kr") 				// KISTI
		|| strpos($_REQUEST['url'], "krm.or.kr") 				// KRM (한국연구재단)
		
	) {  
		// 1. By Pass redirect 할 TarREQUEST
		header("Location: ".$_REQUEST['url']);
	} else {
		// 2-1. EBSCO 자원 처리
		if (strpos($_REQUEST['url'], "search.ebscohost.com") == true || strpos($_REQUEST['url'], "resolver.ebscohost.com") == true) {			
			//header("Location: ".urlencode(urldecode($_REQUEST['url']))."&custid=s5973143&authtype=ip,shib");
			header("Location: ".$_REQUEST['url']."&custid=s5973143&authtype=ip,shib");		
		// 2-2. JCR 처리
		} else if (strpos($_REQUEST['url'], "jcr.clarivate.com") == true) {			
		header("Location: "."http://login.incites.clarivate.com/?auth=ShibbolethIdPForm2_IC2JCR&entityID=https://idp.bucheon.schmc.ac.kr/entity&ShibFederation=OpenAthensFederation");
 		// 기본(go.openathens.net/redirector) 처리 
		} else {			
			header("Location: "."https://go.openathens.net/redirector/bucheon.schmc.ac.kr?url=".urlencode($_REQUEST['url']));
		}
		
	}
	
	//echo '</script>';
	
?>