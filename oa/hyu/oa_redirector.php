<?php
	header("Content-Type: text/html;charset=UTF-8");
	//session_start();
	//echo '<script>';
	//echo 'console.log("test1")';

	$eUrl = NULL;
	$dUrl = NULL;


	$whole_uri = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    echo $whole_uri."<br>";
	echo $_SERVER['REQUEST_URI']."<br>";
	echo $_SERVER['QUERY_STRING']."<br>";
	//echo PHP_URL_QUERY."<br>";
	//echo parse_url($query, PHP_URL_QUERY)."<br>";

	exit;

	if (!$_REQUEST["url"]) {
		
		echo '<script>';
		echo 'alert("해당 전자자원의 접속 정보가 없습니다!\n 도서관에 문의해주세요.");';
		echo 'location.replace("https://lib.hanyang.ac.kr/");';
		echo '</script>';
		exit;
	}

	if (strpos($_REQUEST['url'], "go.openathens.net")) {
		//echo $_REQUEST["url"];
		$dUrl = urldecode($_REQUEST["url"]);
		//echo $dUrl."<br>";		
		//echo substr($dUrl, strpos($dUrl, "url=")+4)."<br>";		
		$eUrl = urlencode(substr($dUrl, strpos($dUrl, "url=")+4));
		//echo "https://go.openathens.net/redirector/hanyang.ac.kr?url=".$eUrl."<br>";
		//exit;
		header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=".$eUrl);
		exit;		
	}
	
	//exit;
	// tarREQUESTUrl 별 athenized url 처리
	// OpenAthens 비적용 전자자원
	if (strpos($_REQUEST['url'], "apis.ebsco.com") 
		|| strpos($_REQUEST['url'], "research.ebsco.com") 		
		|| strpos($_REQUEST['url'], "gssapps.ebscohost.com") 
		|| strpos($_REQUEST['url'], "hanyang.ac.kr") 
		|| strpos($_REQUEST['url'], "bigkinds.or.kr") 
		|| strpos($_REQUEST['url'], "biomedcentral.com") 
		|| strpos($_REQUEST['url'], "rss.bwise.kr") 
		|| strpos($_REQUEST['url'], "bookzip.co.kr") 
		|| strpos($_REQUEST['url'], "dataguide.co.kr") 
		|| strpos($_REQUEST['url'], "dcollection") 
		|| strpos($_REQUEST['url'], "doaj.org") 
		|| strpos($_REQUEST['url'], "donga.com") 
		|| strpos($_REQUEST['url'], "els-nursingskills.kr") 
		|| strpos($_REQUEST['url'], "fric.kr") 
		|| strpos($_REQUEST['url'], "jstage.jst.go.jp") 
		//|| strpos($_REQUEST['url'], "ieee.org") 
		|| strpos($_REQUEST['url'], "kci.go.kr") 
		|| strpos($_REQUEST['url'], "kipris.or.kr") 
		|| strpos($_REQUEST['url'], "kisti.re.kr") 
		|| strpos($_REQUEST['url'], "kita.net") 
		|| strpos($_REQUEST['url'], "koreamed.org") 
		|| strpos($_REQUEST['url'], "kostat.go.kr") 
		|| strpos($_REQUEST['url'], "krm.or.kr") 
		|| strpos($_REQUEST['url'], "kuselit.de") 
		//|| strpos($_REQUEST['url'], "lexis.com") 
		//|| strpos($_REQUEST['url'], "lexis360.fr") 
		//|| strpos($_REQUEST['url'], "lexis-asone.jp") 
		//|| strpos($_REQUEST['url'], "lexicn.com") 
		|| strpos($_REQUEST['url'], "mendeley.com") 
		|| strpos($_REQUEST['url'], "museum.go.kr") 
		|| strpos($_REQUEST['url'], "micromedexsolutions.com") 
		|| strpos($_REQUEST['url'], "nytimesineducation.com") 
		|| strpos($_REQUEST['url'], "ncbi.nlm.nih.gov") 
		|| strpos($_REQUEST['url'], "nicebizline.com") 
		|| strpos($_REQUEST['url'], "nrf.re.kr") 
		|| strpos($_REQUEST['url'], "nytimes.com") 
		|| strpos($_REQUEST['url'], "oversea.cnki.net") 
		|| strpos($_REQUEST['url'], "prism.go.kr") 
		|| strpos($_REQUEST['url'], "riss.kr") 
		|| strpos($_REQUEST['url'], "scourt.go.kr") 
		|| strpos($_REQUEST['url'], "serinu.co.kr") 		
		|| strpos($_REQUEST['url'], "snu.ac.kr") 
		|| strpos($_REQUEST['url'], "trendbird.biz") 
		|| strpos($_REQUEST['url'], "uptodate.com") 		
		|| strpos($_REQUEST['url'], "valuesearch.co.kr") 		
		|| strpos($_REQUEST['url'], "wharton.upenn.edu") 		
		|| strpos($_REQUEST['url'], "westlawjapan.com") 
		|| strpos($_REQUEST['url'], "zkg.de")
	) {
	// 1. By Pass redirect 할 TarREQUEST
		header("Location: ".$_REQUEST['url']);
	} else {
		// 2-1. EBSCO 자원 처리
		if (strpos($_REQUEST['url'], "search.ebscohost.com") == true || strpos($_REQUEST['url'], "resolver.ebscohost.com") == true) {
			header("Location: ".$_REQUEST['url']."%26custid%3Ds5973143%26authtype%3Dip%2Cshib");
		// 2-2. ProQuest DB 처리
		} else if (strpos($_REQUEST['url'], "search.proquest.com") == true) {			
			header("Location: ".$_REQUEST['url']."&authtype=sso");
		// 2-3. ProQuest eBook 처리
		} else if (strpos($_REQUEST['url'], "ebookcentral.proquest.com") == true) {			
			header("Location: ".$_REQUEST['url']);
		// 2-4. Oxford Music Online 처리
		} else if (strpos($_REQUEST['url'], "oxfordmusiconline.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=https%3A%2F%2Fwww.oxfordmusiconline.com%2F&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-5. Oxford Art Online 처리
		} else if (strpos($_REQUEST['url'], "oxfordartonline.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=https%3A%2F%2Fwww.oxfordartonline.com%2Fbenezit&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-6. Oxford Music Online 처리
		} else if (strpos($_REQUEST['url'], "oxfordreference.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=https%3A%2F%2Fwww.oxfordreference.com%2F&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-7. OUP / Oxford Handbooks / Near Archive / OSO / OxMED 처리
		} else if (strpos($_REQUEST['url'], "academic.oup.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=".$_REQUEST['url']."&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-8. Oxford Scholarship Online 처리
		} else if (strpos($_REQUEST['url'], "oxford.universitypressscholarship.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=".$_REQUEST['url']."&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-9. Oxford English Dictionary (OED) 처리
		} else if (strpos($_REQUEST['url'], "oed.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=".$_REQUEST['url']."&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-10. McGrwwHill accessanesthesiology 처리
		} else if (strpos($_REQUEST['url'], "accessanesthesiology.mhmedical.com") == true) {			
		header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccessanesthesiology.mhmedical.com");
		// 2-11. McGrwwHill accessemergencymedicine 처리
		} else if (strpos($_REQUEST['url'], "accessemergencymedicine.mhmedical.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccessemergencymedicine.mhmedical.com");
		// 2-12. McGrwwHill accessmedicine 처리
		} else if (strpos($_REQUEST['url'], "accessmedicine.mhmedical.com") == true) {			
		header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccessmedicine.mhmedical.com");
		// 2-13. McGrwwHill accesspediatrics 처리
		} else if (strpos($_REQUEST['url'], "accesspediatrics.mhmedical.com") == true) {	
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccesspediatrics.mhmedical.com");
		// 2-14. McGrwwHill accesspharmacy 처리
		} else if (strpos($_REQUEST['url'], "accesspharmacy.mhmedical.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccesspharmacy.mhmedical.com");
		// 2-15. McGrwwHill accessphysiotherapy 처리
		} else if (strpos($_REQUEST['url'], "accessphysiotherapy.mhmedical.com") == true) {			
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccessphysiotherapy.mhmedical.com");
		// 2-16. McGrwwHill accesssurgery 처리		
		} else if (strpos($_REQUEST['url'], "accesssurgery.mhmedical.com") == true) {
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Faccesssurgery.mhmedical.com");
		// 2-17. McGrwwHill accesssurgery 처리		
		} else if (strpos($_REQUEST['url'], "boneandjoint.org") == true) {
			header("Location: "."https://proxy.openathens.net/login?&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=https%3A%2F%2Fboneandjoint.org.uk%2Fjournal%2Fbjj");
		// 기본(go.openathens.net/redirector) 처리 
 		} else {			
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=".urlencode($_REQUEST['url']));
		}		
	}
	
	//echo '</script>';
	
?>