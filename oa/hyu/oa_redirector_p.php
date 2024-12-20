<?php
	header("Content-Type: text/html;charset=UTF-8");
	//session_start();
	//echo '<script>';
	//echo 'console.log("test1")';

	$eUrl = NULL;
	$dUrl = NULL;
	$sid  = NULL;

	//echo $_REQUEST["url"]."<br>";
	//exit;

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
		//if (strpos($dUrl, "sid=")) {
		//	$sid = substr($dUrl, strpos($dUrl, "sid=")+4);
		//}

		if (strpos($dUrl, "asce")) { 
			header("Location: "."https://proxy.openathens.net/login?qurl=".$eUrl);
		}
		else {
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=".$eUrl);
		}
		
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
		|| strpos($_REQUEST['url'], "ft.com") 
		|| strpos($_REQUEST['url'], "icpsr.umich.edu") 
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
		|| strpos($_REQUEST['url'], "oreilly.com") 
		//|| strpos($_REQUEST['url'], "oversea.cnki.net") 
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
		|| strpos($_REQUEST['url'], "wsj.com") 
		|| strpos($_REQUEST['url'], "zkg.de")
	) {  
		// 1. By Pass redirect 할 TarREQUEST
		header("Location: ".$_REQUEST['url']);
	} else {
		// 2-1. EBSCO 자원 처리
		if (strpos($_REQUEST['url'], "search.ebscohost.com") == true || strpos($_REQUEST['url'], "resolver.ebscohost.com") == true) {			
			//header("Location: ".urlencode(urldecode($_REQUEST['url']))."&custid=s5973143&authtype=ip,shib");
			header("Location: ".$_REQUEST['url']."&custid=s5973143&authtype=ip,shib");
		// 2-2. ProQuest DB 처리
		//} else if (strpos($_REQUEST['url'], "search.proquest.com") == true) {			
		//	header("Location: ".$_REQUEST['url']."&authtype=sso");
		// 2-2. ProQuest eBook 처리
		} else if (strpos($_REQUEST['url'], "ebookcentral.proquest.com") == true) {			
			header("Location: ".$_REQUEST['url']);
		// 2-3. Oxford Music Online 처리
		} else if (strpos($_REQUEST['url'], "oxfordmusiconline.com") == true) {			
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=https%3A%2F%2Fwww.oxfordmusiconline.com%2F");
		// 2-4. Oxford Art Online 처리
		} else if (strpos($_REQUEST['url'], "oxfordartonline.com") == true) {		
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=https%3A%2F%2Fwww.oxfordartonline.com%2Fbenezit");
		// 2-5. Oxford Reference 처리
		} else if (strpos($_REQUEST['url'], "oxfordreference.com") == true) {
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=https%3A%2F%2Fwww.oxfordreference.com%2F");
		// 2-6. ASCE 처리
		} else if (strpos($_REQUEST['url'], "ascelibrary.org") == true) {			
			header("Location: "."https://proxy.openathens.net/login?qurl=https%3A%2F%2Fascelibrary.org%2F&entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity");
		// 2-7. OSIRIS, ORBIS M&A 처리		
		} else if (strpos($_REQUEST['url'], "bvdinfo.com") == true) {
			header("Location: "."https://proxy.openathens.net/login?entityID=https%3A%2F%2Fidp.hanyang.ac.kr%2Fentity&qurl=".urlencode($_REQUEST['url']));
 		// 기본(go.openathens.net/redirector) 처리 
		} else {			
			header("Location: "."https://go.openathens.net/redirector/hanyang.ac.kr?url=".urlencode($_REQUEST['url']));
		}
		
	}
	
	//echo '</script>';
	
?>