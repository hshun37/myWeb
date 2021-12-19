<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta property="og:image" content="../images/opengraph.png">
    <title>기상청 날씨누리</title>
    <link rel="stylesheet" href='/wgis-nuri/css/ol.css'>
    <link rel="stylesheet" href='/wgis-nuri/css/reset.css?v=202111121900'>
    <link rel="stylesheet" href='/wgis-nuri/css/map.css?v=202111121900'>
    <link rel="stylesheet" href='/wgis-nuri/css/kmap.css?v=202111121900'>
    <link rel="stylesheet" href='/wgis-nuri/css/mobile.css?v=202111121900'>
    <link rel="stylesheet" href='/wgis-nuri/css/legend.css?v=202111121900'>
    <script src='/wgis-nuri/js/ol/ol.js'></script>
    <script src='/wgis-nuri/js/proj4/proj4.js'></script>
    <script src='/wgis-nuri/js/jsPDF/1.5.3/jspdf.min.js'></script>
    <script src='/wgis-nuri/js/dom-to-image/2.8.0/dom-to-image-more.min.js'></script>
    <script src='/wgis-nuri/js/vue/vue.js'></script>
    <link rel="shortcut icon" href='../images/logo_mark_pv.ico'>

    <script>
    	var APP_URL = "/wgis-nuri";
    	var GEOSERVER_URL = 'https://www.weather.go.kr/wgis-geos';
    	var GEOSERVER_WORKSPACE = 'kma_2021';
    	var SEARCH_URL = "https://www.weather.go.kr";
    	var IS_WINTER = true;
    	var IS_GK2A = true;
    	var param_zoom = ""
    	var param_location = ""
    	var param_center = ""

    	// IE Redirect
		var agent = navigator.userAgent.toLowerCase();
		if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) { // IE 일 경우
			window.location.href = APP_URL + "/map/info";
		}
		
    	// localStorage에 접근하는 STORE
    	var STORE = {
    	    description: [
        	    {key: "W_AC", desc: "풍속의 단위"},
    	    	{key: "cmpLocalSearchLog", desc: "최근 검색 지역 목록"}
    	    ],
    	    store: window.localStorage,
    	    getItem: function(key) {
    	    	if(!this.existsItem(key)) return false;
    	        const data = this.store[key];
    	        return JSON.parse(data);
    	    },
    	    setItem: function(key, data) {
        	    // ★ 주의사항
        	    // ★ 기존의 key, value를 잘 보고  덮어쓰지 않도록 주의
    	        this.store[key] = JSON.stringify(data);
    	    },
    	    validItem: function(key, value) {
    	        if(!this.existsItem(key)) {
    	        	this.createItem(key, value);
    	        }
    	    },
    	    existsItem: function(key) {
    	    	return this.store[key] ? true : false;
       	    },
    	    createItem: function(key, value) {
    	    	this.store.setItem(key, JSON.stringify(value));
       	    },
       	    removeItem: function(key) {
    	    	this.store.removeItem(key);
         	}
    	}
    	STORE.validItem("W_AC", {"unit":{"ws":"m/s"},"displayMode":"default","panelOrder":{"main":[{"id":"weather","name":"예보","tab":2,"on":true,"tabIndex":1},{"id":"map","name":"지도(강수)","tab":1,"on":false,"tabIndex":0}]}});
    </script>

    <script src='/wgis-nuri/js/info/config.js?v=202111121900'></script>
    <script src='/wgis-nuri/js/info/dfsLegends.js?v=202111121900'></script>
    <script src='/wgis-nuri/js/common/windy.js?v=202111121900'></script>
    <script src='/wgis-nuri/js/common/kmap.js?v=202111121900'></script>
	
    <script>
		// vue객체 간 데이터 공유
		/**
		 *  'config': 설정의 풍속 단위 'config': 설정의 풍속 단위
		 */
		let EventBus = new Vue();
    </script>
</head>
<body>
<div class="wrap">
    <div class="map" id="map"></div>
    <div id="popup"></div>
    <!-- TODO: 팝업의 위치를 어디에 두면 좋을까..? -->
    <!-- // MAP -->
    
    <div class="gnb" id="title">
        <h1>기상청 날씨지도</h1>
        <div class="gnb-section">
            <div class="gnbBtns">
	       		<div class="gnb-place">
	        		<div class="place">
		                <input type="text" size="15" placeholder="읍/면/동 정보 조회" v-model="searchText" v-on:focus="getRecent();showList=true;" v-on:blur="showList=false" v-on:keydown="checkEnter($event, 'searchLocation')"> <!-- 키워드 입력 input -->
		                <button type="button" title="검색" id="searchLocation" class="search" v-on:focus="getSearchList();showList=true;" v-on:blur="showList=false">검색</button>
		                <button type="button" title="관심지역" class="bookmark" v-on:focus="getBookmark();showList=true;" v-on:blur="showList=false">관심지역</button>
		            	
		               	<template v-if="searchList.length > 0">
		                	<template v-if="searchType == 'recent'">
				                <ul v-if="showList || hoverList" class="log-list" v-on:mouseover="hoverList=true" v-on:mouseout="hoverList=false;">
				                	<li v-for="item in searchList" v-on:click="clickRecentList(item);hoverList=false">
				                    	<span>{{ item.query }}</span>
				                   	</li>
				            	</ul>
	                  		</template>
	                  		<template v-if="searchType == 'search'">
				                <ul v-if="showList || hoverList" class="local-list" v-on:mouseover="hoverList=true" v-on:mouseout="hoverList=false;">
				                	<li v-for="item in searchList" v-on:click="clickSearchList(item);hoverList=false">
				                    	<button title="북마크" type="button" class="bookmark on" v-if="item.bookmark" v-on:click.stop="removeBookmarkBySearch(item);showList=true;">★</button>
				                    	<button title="북마크" type="button" class="bookmark" v-if="!item.bookmark" v-on:click.stop="addBookmark(item);showList=true;">★</button>
				                    	<span class="local-tit">{{ item.title }}</span><span>{{ item.address }}</span>
				                   	</li>
									<li class="more" v-on:click="getSearchList(searchPage)">+더보기</li>
				            	</ul>
	                  		</template>
	                  		<template v-if="searchType == 'bookmark'">
				                <ul v-if="showList || hoverList" class="local-list" v-on:mouseover="hoverList=true" v-on:mouseout="hoverList=false;">
				                	<li v-for="item in searchList" v-on:click="clickBookmarkList(item);showList=false;hoverList=false">
				                    	<button title="북마크" type="button" class="bookmark on" v-on:click.stop="removeBookmark(item);showList=true;">★</button>
				                    	<span class="local-tit">{{ item.dong.name }}</span><span>{{ item.fullName }}</span>
				                   	</li>
				            	</ul>
	                  		</template>
	                  	</template>
	                  	<template v-if="searchList.length == 0">
		                  	<ul v-if="showList || hoverList" class="local-list" v-on:mouseover="hoverList=true" v-on:mouseout="hoverList=false;">
			                	<li>
			                    	<span>{{ emptyMessage[searchType] }}</span>
			                   	</li>
			                   	<!-- <li class="more">+더보기</li> -->
		                  	</ul>
	                  	</template>
						<!-- 검색어에 따른 자동완성, 처음 클릭시 관심지역이 보여짐, 글자입력시 class="bookmark"삭제됨 -->
	                </div>
	                <div class="mobile-only loaded">
	                   	<button type="button" title="검색" class="ico search" v-on:click="getRecent();showList=true;">검색</button>
	                    <!-- MOBILE 검색 -->
	                    <div class="mobile-wrap" v-show="showList">
	                        <div class="mobile-header">
	                            <div>
	                                <button type="button" title="레이어닫기" class="back" v-on:click="showList=false;">레이어닫기</button>
	                            </div>
	                            <div>
	                                <input type="text" size="15" placeholder="읍/면/동 정보 조회" v-model="searchText" v-on:click="getRecent();showList=true;" v-on:keydown="checkEnter($event, 'searchLocationM')">
	                            </div>
	                            <div>
	                                <button type="button" title="검색" id="searchLocationM" class="search" v-on:click="getSearchList();showList=true;">검색</button>
	                                <button type="button" title="관심지역" class="bookmark" v-on:click="getBookmark();showList=true;">관심지역</button>
	                            </div>
	                        </div>
	                        <div class="mobile-contents">
	                        	<template v-if="searchList.length > 0">
				                	<template v-if="searchType == 'recent'">
						                <ul v-if="showList" class="log-list">
						                	<li v-for="item in searchList" v-on:click="clickRecentList(item);hoverList=false">
						                    	<span>{{ item.query }}</span>
						                   	</li>
						            	</ul>
			                  		</template>
			                  		<template v-if="searchType == 'search'">
						                <ul v-if="showList" class="local-list">
						                	<li v-for="item in searchList" v-on:click="clickSearchList(item);hoverList=false">
						                    	<button title="북마크" type="button" class="bookmark on" v-if="item.bookmark" v-on:click.stop="removeBookmarkBySearch(item);showList=true;">★</button>
						                    	<button title="북마크" type="button" class="bookmark" v-if="!item.bookmark" v-on:click.stop="addBookmark(item);showList=true;">★</button>
						                    	<span class="local-tit">{{ item.title }}</span><span>{{ item.address }}</span>
						                   	</li>
											<li class="more" v-on:click="getSearchList(searchPage)">+더보기</li>
						            	</ul>
			                  		</template>
			                  		<template v-if="searchType == 'bookmark'">
						                <ul v-if="showList" class="local-list">
						                	<li v-for="item in searchList" v-on:click="clickBookmarkList(item);showList=false;hoverList=false">
						                    	<button title="북마크" type="button" class="bookmark on" v-on:click.stop="removeBookmark(item)">★</button>
						                    	<span class="local-tit">{{ item.dong.name }}</span><span>{{ item.fullName }}</span>
						                   	</li>
						            	</ul>
			                  		</template>
			                  	</template>
			                  	<template v-if="searchList.length == 0">
				                  	<ul v-if="showList" class="local-list">
					                	<li>
					                    	<span>{{ emptyMessage[searchType] }}</span>
					                   	</li>
					                   	<!-- <li class="more">+더보기</li> -->
				                  	</ul>
			                  	</template>
	                        </div>
	                    </div>
	                    <!-- // MOBILE 검색 -->
	            	</div>
	           	</div>
                <div class="gnb-area">
                    <button type="button" title="내 위치로 가기" class="ico location" v-on:click="geolocation()">내 위치로 가기</button>
                </div>
                <div class="gnb-setup">
                    <button type="button" title="설정" class="ico setup" :class="{'on': openConfig}" v-on:click="toggleConfig()">설정</button>
                	<!-- 설정 -->
			        <div class="layer setup loaded" v-show="openConfig">
			           	<div class="setup-contents">
			           		<h4>풍속 설정</h4>
					        <label for="setup-ws-ms"><input type="radio" name="setup-ws" id="setup-ws-ms" value="m/s" v-model="config.unit.ws"> m/s</label> 
					        <label for="setup-ws-kmh"><input type="radio" name="setup-ws" id="setup-ws-kmh" value="km/h" v-model="config.unit.ws"> km/h</label>
					    </div>
					    <div class="setup-btn">
					        <button type="button" v-on:click="saveConfig()" class="text-btn type1">저장</button>
					    </div>
				        <button type="button" v-on:click="toggleConfig(false)" class="close">레이어 닫기</button>
			       </div>
                </div>
                <!-- <div class="gnb-share">
                    <button type="button" title="저장" class="ico share" :class="{'on': shareDisplay}" v-on:click="shareOpen()">저장</button>
        			저장
        			<div class="layer share loaded" v-show="shareDisplay">
            			<ul>
              			  	<li id="screenshot" class="capture" v-on:click="screenshot()"> 화면캡쳐</li>
                			<li id="print" class="print" v-on:click="print()"> 화면인쇄</li>
              			  	<li>
	              			  	<a id="image-download" download="map.png"></a>
              			  	</li>
            			</ul>
            			<button type="button" class="close" v-on:click="shareClose()">레이어 닫기</button>
        			</div>
                </div> -->
                <div class="gnb-intro">
                	<button type="button" title="도움말" class="ico guide" v-on:click="openGuide()">도움말</button>
			        <!-- intro -->
			        <div class="introWrap loaded" v-show="showIntro">
			            <div class="help-tit help-sys">
			                <ul>
			                    <li class="on">시스템이용 도움말</li>
			                    <li v-on:click="toggleGuide()">기상자료 도움말</li>
			                </ul>
			            </div>
			            <div class="introCenterWrap">
			                <div class="introLogo">기상청 날씨누리</div>
			                <div class="introBtn">
			                    <!-- <button v-on:click="stopIntro()">오늘 다시 보지 않기</button> -->
			                    <button v-on:click="closeIntro()">닫기</button>
			                </div>
			            </div>
			            <div class="introLayer">기상자료를 선택할 수 있어요</div>
			            <div class="introGnb">위치검색, 관심지역, 내위치로</div>
			            <div class="introCtrl">지도확대, 지도축소, 거리, 배경지도, 자료 새로고침</div>
			            <div class="introTime"></div>
			        </div>
			        <!-- 도움말 -->
			        
<!-- 기상자료 도움말 -->
<div class="introWrap system-help loaded" v-show="showGuide">
    <div class="helpWrap" >
        <div class="help-tit">
            <ul>
                <li v-on:click="toggleIntro()">시스템이용 도움말</li>
                <li class="on">기상자료 도움말</li>
            </ul>
            <button type="button" title="닫기" v-on:click="closeGuide()">닫기</button>
        </div>
        
        <ul class="help-tab">
            <li><a href="#sat">위성</a></li>
            <li><a href="#ladar">레이더</a></li>
            <li><a href="#observe">관측</a></li>
            <li><a href="#forecast">동네예보</a></li>
            <li><a href="#news">특보</a></li>
            <li><a href="#impact">영향예보</a></li>
            <li><a href="#short">초단기예측</a></li>
            <li><a href="#marine">해구예측</a></li>
            <li><a href="#load">도로기상</a></li>
        </ul>

        <div class="helpContents">
            <div id="sat" class="help-group">
                <h2 class="h2-help">
                    위성
                </h2>
                <p>
                    천리안위성 2A호(GEO-KOMPSAT-2A: GK2A)는 10분 간격으로 전지구지역을 관측하며, 2분 간격으로 한반도 주변지역을 관측하기 때문에 천리안위성보다 신속하게 기상재해 감시와 대비가 가능합니다. 2018년 12월 5일에 발사된 천리안위성 2A호는 일본, 미국 위성들과 더불어 세계 최고 수준의 기상센서를 탑재하였습니다. 이에 따라 밴드 수는 가시에서 적외 파장대에 걸쳐 5개에서 16개로, 공간해상도는 적외밴드의 경우 4㎞에서 2㎞로, 가시밴드는 1km에서 최대 500m까지 4배 향상되었고, 관측주기는 한반도 기준 15분에서 2분으로 천리안위성 1호 보다 성능이 크게 발전되었습니다. 천리안위성 2A호의 고해상도 관측자료로부터 태풍의 중심위치 분석이 보다 정확해져 태풍의 이동 경로를 효과적으로 추적할 수 있고, 관측시간을 단축해 국지적 집중호우의 발달을 조기에 탐지할 수 있게 되었습니다. 특히 천연색컬러로 지구를 관측할 수 있게 됨에 따라 다른 분석기술 없이, 육안으로 구름, 산불연기, 황사 등의 구분이 가능한 영상을 제공할 수 있게 되었습니다.
                </p>
                <div class="img-group">
                    <p class="img-left">
                        <span>천리안위성 2A호가 관측한 적외영상</span>
                        <img v-bind:src="infrared" alt="천리안위성 2A호가 관측한 적외영상">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>구름이나 물체에서 방출되는 온도를 탐지기 때문에 온도가 낮을수록 하얗게, 온도가 높을수록 검은색 계열로 표현됩니다. 주야간 구름의 발달/이동, 구름/대기 특성, 위험기상감시, 열대저기압/태풍 분석 등에 주로 활용됩니다.
                        </li>
                        <li>
                            <label>주목적</label>구름 탐지
                        </li>
                        <li>
                            <label>관측시간</label>주간/야간
                        </li>
                        <li>
                            <label>중심파장</label>10.5㎛ 
                        </li>
                        <li>
                            <label>공간해상도</label>2km
                        </li>
                    </ul>
                </div>

                <div class="img-group">
                    <p class="img-left">
                        <span>천리안위성 2A호가 관측한 가시영상</span>
                        <img  v-bind:src="visible" alt="천리안위성 2A호가 관측한 가시영상">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>사람이 보는 가시광선의 장파장대(붉은색)를 이용하여 물체나 구름에서 반사되는 태양복사에너지를 관측하기 때문에 반사가 잘되는 물질은 하얗게, 반사가 적게 되는 물질은 검은색 계열로 표출됩니다. 태양복사에너지를 이용하기 때문에 주간에만 제공되며, 공간해상도는 0.5km로 16개 밴드 중 가장 고해상도 정보를 제공하며, 안개, 적설, 대류운 등 위험기상감시, 일사량 추정 등에 사용됩니다.
                        </li>
                        <li>
                            <label>주목적</label>구름 감시
                        </li>
                        <li>
                            <label>관측시간</label>주간
                        </li>
                        <li>
                            <label>중심파장</label>0.64㎛ (Red) 
                        </li>
                        <li>
                            <label>공간해상도</label>0.5km
                        </li>
                    </ul>
                </div>

                <div class="img-group">
                    <p class="img-left">
                        <span>천리안위성 2A호가 관측한 수증기영상</span>
                        <img  v-bind:src="steam" alt="천리안위성 2A호가 관측한 수증기영상">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>대류권 상부(최대 기여고도: 약 300hPa)의 수증기의 흡수정도를 관측하여 상층 수증기 분포를 나타내며, 수증기가 많을수록 하얗게, 수증기가 적은 건조역은 검은색으로 표현됩니다. 상층 수증기와 건조역의 분포를 통해 대류권 상층 수증기 추적, 제트기류 분석, 기압골/기압능, 변형장 등 종관장 분석 등에 활용됩니다.
                        </li>
                        <li>
                            <label>주목적</label>상층 수증기 부포 감시
                        </li>
                        <li>
                            <label>관측시간</label>주간/야간
                        </li>
                        <li>
                            <label>중심파장</label>6.9㎛ 
                        </li>
                        <li>
                            <label>공간해상도</label>2km
                        </li>
                    </ul>
                </div>

                <div class="img-group">
                    <p class="img-left">
                        <span>RGB 천연색 합성영상</span>
                        <img  v-bind:src="rgb" alt="">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>사람의 눈으로 볼 수 있는 가시영역에 해당하는 파랑(0.47㎛), 초록(0.51㎛), 빨강(0.64㎛)색을 합성하여 사람이 보는 것과 동일한 색상으로 표현한 영상입니다.
                        </li>
                        <li>
                            <label>주목적</label>주간의 구름분석, 황사, 스모그, 식생지역 등의 현상 분석
                        </li>
                        <li>
                            <label>관측시간</label>주간
                        </li>
                        <li>
                            <label>공간해상도</label>1km
                        </li>
                    </ul>
                </div>
                
                <div class="img-group">
                    <p class="img-left">
                        <span>안개영상</span>
                        <img  v-bind:src="fog" alt="안개영상">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>0~6의 값으로 표현되며 0에 가까울 수록 안개에 가깝고, 6에 가까울수록 하층운으로 분석할 수 있습니다.
                        </li>
                        <li>
                            <label>관측시간</label>주간/야간
                        </li>
                        <li>
                            <label>공간해상도</label>2km
                        </li>
                    </ul>
                </div>

                <div class="img-group">
                    <p class="img-left">
                        <span>황사영상</span>
                        <img  v-bind:src="dust" alt="황사영상">
                    </p>
                    <ul class="help-list">
                        <li>
                            <label>관측주기</label>동아시아 10분 간격
                        </li>
                        <li>
                            <label>특성</label>화산재, 황사, 에어로졸을 탐지하여 색상으로 구분하여 표시합니다.
                        </li>
                        <li>
                            <label>관측시간</label>주간
                        </li>
                        <li>
                            <label>공간해상도</label>2km
                        </li>
                    </ul>
                </div>
            </div>
            <!-- // 위성 -->

            <div id="ladar" class="help-group">
                <h2 class="h2-help">레이더</h2>
                <p>
                    레이더 자료는 위성의  적외, 가시, 수증기, RGB 천연색 영상과 중첩 조회 할 수 있습니다.
                </p>
                <p><label>표출 영역</label> 한반도 N30~44, E118~134</p>

                <h3 class="h3-help">누적강수</h3>
                <p>
                    5분 간격의 레이더 합성영상을 1시간동안 누적한 정보
                </p>
                <ul class="help-list">
                    <li>
                        <label>제공주기</label>매 10분 간격
                    </li>
                    <li>
                        <label>표출 영역 </label>남한을 포함하는 레이더관측 범위
                    </li>
                    <li>
                        <label>검색가능 영상</label>현재부터 이전 1h 동안 자료까지 표출
                    </li>
                    <li>
                        <label>동화 간격</label>10분
                    </li>
                </ul>

                <h3 class="h3-help">눈비영역</h3>
                <p>
                    레이더, 지상관측, 고층관측, 수치정보 등을 종합하여 레이더 강수의 눈비영역을 구별한 정보
                </p>
                <ul class="help-list">
                    <li>
                        <label>제공주기</label>매 10분 간격
                    </li>
                    <li>
                        <label>표출 영역 </label>남한을 포함하는 레이더관측 범위
                    </li>
                    <li>
                        <label>검색가능 영상</label>현재부터 이전 1h 동안 자료까지 표출
                    </li>
                    <li>
                        <label>동화 간격</label>10분
                    </li>
                </ul>

                <h3 class="h3-help">낙뢰</h3>
                <p>
                    기상청 낙뢰시스템에서 관측된 낙뢰(대지방번) 정보
                    10분 간격 시간 순서대로 낙뢰 위치정보를 분석하여 60분 동안의 낙뢰 정보를 지도상에 색깔로 나타냄
                </p>
                <ul class="help-list">
                    <li>
                        <label>제공주기</label>매 10분 간격
                    </li>
                    <li>
                        <label>표출 영역 </label>남한(인근 해상)
                    </li>
                    <li>
                        <label>검색가능 영상</label>현재부터 이전 1h 동안 자료까지 표출
                    </li>
                    <li>
                        <label>동화 간격</label>10분
                    </li>
                </ul>

            </div>
            <!-- // 레이더 -->

            <div id="observe" class="help-group">
                <h2 class="h2-help">관측</h2>
                <p><label>표출 영역</label> 남한</p>
                <ul class="help-list">
                    <li>
                        <label>지상</label>ASOS , AMOS , AWS 를 포함한 육상 관측 정보입니다.

                        <ul class="help-list-sub">
                            <li>
                                <label>ASOS</label>
                                유인관측소(기상대)에 설치된 자동 지상관측시스템(Automated Surface Observing System)에서 생산되는 기상관측 자료입니다. 
                            </li>
                            <li>
                                <label>AMOS</label>
                                활주로 근처에 설치된  자동 기상관측장비(Aerodrome Meteorological Observation Systems)에서 생산되는 기상관측 자료입니다.
                            </li>
                            <li>
                                <label>AWS</label>
                                기상청에서 운영 중인 무인자동기상관측장비(Automatic Weather System, AWS)에서 생산되는 기상관측 자료입니다.
                            </li>
                            <li>
                                <span class="help-tag">주의</span> 유인관측소와 달리 무인자동관측장비의 관측자료는 기계적인 오작동이나 통신 장애 등으로 잘못된 관측자료가 나올 수 있으므로, 여기서 제공되는 실시간 서비스 자료는 참조용으로만 사용 가능하며, 기상증명과 같은 증빙자료로 사용할 수 없습니다.
                            </li>
                        </ul>

                    </li>
                    <li>
                        <label>부이</label>해양기상부이는 해수면에서 해양기상현상을 다양한 기상장비로 관측하고, 위성 등 원격통신을 이용하여 관측자료를 전송하는 장비이며, 형태는 선박형과 원반형 두 가지가 있습니다. 관측자료는 풍향, 풍속, 기압, 기온, 습도, 파고, 파주기, 파향, 수온 등을 1시간 간격으로 관측하고 있습니다.
                    </li>
                    <li>
                        <label>등표</label>등표기상관측장비는 등표나 관측탑 등의 해양 구조물에 기상관측장비를 설치하고 수중에는 해상상태를 측정할 수 있는 파고계 등을 설치하여 관측한 자료를 위성 및 CDMA 등을 이용하여 전송하는 장비입니다. 등표기상관측장비에서 관측하는 요소는 풍향, 풍속, 기압, 기온, 파고, 파주기, 수온 등을 30분 간격으로 관측을 하고 있습니다.
                    </li>
                    <li>
                        <label>파고부이</label>파고부이는 직경 약 70cm의 소형으로, 해양기상부이 보다 근해에 설치하여, 연안바다의 복잡한 지형에 의해 국지적으로 서로 달리 나타나는 파고를 관측하여 CDMA로 자료를 전송하는 장비입니다. 1시간 주기로 관측하고 관측요소는 파고, 파주기, 수온 등입니다.
                    </li>
                    <!-- <li>
                        <label>공항</label>METAR 로 발행되는 공항 관측 정보입니다. 공항예보는  동네예보가 아닌 TAF라는 전문으로 발행하는 예보가 표시됩니다.
                    </li> -->
                </ul>

            </div>
            <!-- // 관측 -->

            <div id="forecast" class="help-group">
                <h2 class="h2-help">동네예보</h2>
                <p>
                    대상기간과 구역을 시ㆍ공간적으로 세분화(5kmX5km 격자 기반) 하여 발표하는 예보
                </p>
                <p><label>표출 영역</label> 한반도 N31.6~43.3, E123.3~131.7</p>
                <!--
                <h3 class="h3-help">실황</h3>
                <ul class="help-list">
                    <li>
                        <label>예보주기</label>일 144회(10분 간격)
                    </li>
                    <li>
                        <label>예보구간</label>현재
                    </li>
                    <li>
                        <label>예보영역</label>남한 육상
                    </li>
                    <li>
                        <label>예보요소</label>기온, 강수형태, 강수량,습도, 풍향/풍속
                    </li>
                </ul>-->

                <h3 class="h3-help">초단기 예보</h3>
                <ul class="help-list">
                    <li>
                        <label>예보주기</label>일 24회(1시간 간격)
                    </li>
                    <li>
                        <label>예보구간</label>4시간~6시간
                    </li>
                    <li>
                        <label>예보영역</label>한반도 육상
                    </li>
                    <li>
                        <label>예보요소</label>기온, 강수형태, 강수량, 하늘상태, 습도, 풍향/풍속
                    </li>
                </ul>

                <h3 class="h3-help">단기 예보 (동네예보)</h3>
                <ul class="help-list">
                    <li>
                        <label>예보주기</label>일 8회(3시간 간격)
                    </li>
                    <li>
                        <label>예보구간</label>3시간 단위 구간, 모레까지 예보
                    </li>
                    <li>
                        <label>예보영역</label>한반도 육상, 유의파고, 풍향/풍속의 경우 동네예보 구역 해상 포함
                    </li>
                    <li>
                        <label>예보요소</label>기온, 강수형태, 강수확률, 강수량, 적설, 하늘상태, 습도, 풍향/풍속, 유의파고
                    </li>
                </ul>

                <h3 class="h3-help">예보콘텐츠</h3>
                <ul class="help-list">
                    <li>
                        분포도(기온, 강수형태, 강수확률, 강수량, 적설, 하늘상태, 습도, 풍향/풍속, 유의파고 )표현
                    </li>
                    <li>
                        육상 격자 시계열 표현(분포도 요소에 낮최고기온, 아침최저기온 포함)
                    </li>
                    <li>
                        해상 격자 시계열 표현( 풍향/풍속, 유의파고), (육상의 경우 실황, 1시간 단위 구간 4시간~6시간까지 초단기 예보를 포함함)
                    </li>
                </ul>
            </div>
            <!-- // 동네예보 -->


            <div id="news" class="help-group">
                <h2 class="h2-help">특보</h2>
                <p>
                    특보란 각종 기상현상으로 인하여 재해 발생 우려가 있을 때 이를 경고하기 위해 발표하는 기상정보입니다.
                    날씨지도는 현재 발효 중인 특보만 표출합니다.
                </p>
                <p><label>표출 영역</label> 남한 N27~46, E121~140</p>
                <ul class="help-list">
                    <li>
                        <label>기상특보의 종류</label>강풍, 풍랑, 호우, 대설, 건조, 해일, 한파, 태풍, 황사, 폭염(10종)
                    </li>
                    <li>
                        <label>기상특보의 단계</label>주의보, 경보(2단계)
                    </li>
                </ul>
                <h3 class="h3-help">특보 발표 기준</h3>
                <table class="help-table">
                <caption>특보 발표 기준에 대한 도움말을 제공한다.</caption>
                    <colgroup>
                        <col width="70px">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <thead>
                    	<tr>
	                        <th>종류</th>
	                        <th>주의보</th>
	                        <th>경보</th>
                    	</tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>강풍</th>
                            <td>
                                육상에서 풍속 50.4km/h(14m/s) 이상 또는 순간풍속 72.0km/h(20m/s) 이상이 예상될 때. 다만, 산지는 풍속 61.2km/h(17m/s) 이상 또는 순간풍속 90.0km/h(25m/s) 이상이 예상될 때
                            </td>
                            <td>
                                육상에서 풍속 75.6km/h(21m/s) 이상 또는 순간풍속 93.6km/h(26m/s) 이상이 예상될 때. 다만, 산지는 풍속 86.4km/h(24m/s) 이상 또는 순간풍속 108.0km/h(30m/s) 이상이 예상될 때
                            </td>
                        </tr>
                        <tr>
                            <th>풍랑</th>
                            <td>
                                해상에서 풍속 50.4km/h(14m/s) 이상이 3시간 이상 지속되거나 유의파고가 3m 이상이 예상될 때
                            </td>
                            <td>
                                해상에서 풍속 75.6km/h(21m/s) 이상이 3시간 이상 지속되거나 유의파고가 5m 이상이 예상될 때
                            </td>
                        </tr>
                        <tr>
                            <th>호우</th>
                            <td>
                                3시간 강우량이 60mm이상 예상되거나 12시간 강우량이 110mm이상 예상될 때
                            </td>
                            <td>
                                3시간 강우량이 90mm이상 예상되거나 12시간 강우량이 180mm이상 예상될 때
                            </td>
                        </tr>
                        <tr>
                            <th>대설</th>
                            <td>
                                24시간 신적설이 5cm이상 예상될 때
                            </td>
                            <td>
                                24시간 신적설이 20cm이상 예상될 때. 다만, 산지는 24시간 신적설이 30cm이상 예상될 때.
                            </td>
                        </tr>
                        <tr>
                            <th>건조</th>
                            <td>
                                실효습도 35%이하가 2일 이상 계속될 것이 예상될 때
                            </td>
                            <td>
                                실효습도 25% 이하가 2일 이상 계속될 것이 예상될 때
                            </td>
                        </tr>
                        <tr>
                            <th>폭풍해일</th>
                            <td>
                                천문조, 폭풍, 저기압 등의 복합적인 영향으로 해수면이 상승하여 발효기준값 이상이 예상될 때. 다만, 발효기준값은 지역별로 별도지정
                            </td>
                            <td>
                                천문조, 폭풍, 저기압 등의 복합적인 영향으로 해수면이 상승하여 발효기준값 이상이 예상될 때. 다만, 발효기준값은 지역별로 별도지정
                            </td>
                        </tr>
                        <tr>
                            <th>한파</th>
                            <td>
                                <p>10월~4월에 다음 중 하나에 해당하는 경우</p>
                                <ol>
                                    <li>아침 최저기온이 전날보다 15℃ 이상 하강하여 3℃ 이하이고 평년값보다 3℃가 낮을 것으로 예상될 때</li>
                                    <li>아침 최저기온이 -15℃ 이하가 2일 이상 지속될 것이 예상될 때</li>
                                    <li>급격한 저온현상으로 광범위한 지역에서 중대한 피해가 예상될 때</li>
                                </ol>
                            </td>
                            <td>
                                <ol>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>태풍</th>
                            <td>
                                태풍으로 인하여 강풍, 풍랑, 호우, 폭풍해일 현상 등이 주의보 기준에 도달할 것으로 예상될 때
                            </td>
                            <td>
                                태풍으로 인하여 다음 중 어느 하나에 해당하는 경우
                                <ol>
                                    <li>강풍(또는 풍랑) 경보 기준에 도달할 것으로 예상될 때</li>
                                    <li>총 강우량이 200mm이상 예상될 때</li>
                                    <li>푹풍해일 경보 기준에 도달할 것으로 예상될 때</li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <th>황사</th>
                            <td>
                                -
                            </td>
                            <td>
                                황사로 인해 1시간 평균 미세먼지(PM10) 농도 800㎍/㎥이상이 2시간 이상 지속될 것으로 예상될 때
                            </td>
                        </tr>
                        <tr>
                            <th>폭염</th>
                            <td>
                                일최고기온이 33℃ 이상인 상태가 2일 이상 지속될 것으로 예상될 때
                            </td>
                            <td>
                                일최고기온이 35℃ 이상인 상태가 2일 이상 지속될 것으로 예상될 때
                            </td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>

                <p>
                    20년 5월 15일부터 아래의 기준으로 시범운영
                </p>
                <table class="help-table">
                <caption>특보 발표 기준에 대한 도움말을 제공한다.</caption>
                    <thead>
                    	<tr>
	                        <th>구분</th>
	                        <th>주의보</th>
	                        <th>경보</th>
                    	</tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>폭염(시범운영)</th>
                            <td>
                                폭염으로 인하여 다음 중 어느 하나에 해당하는 경우
                                <ol>
                                    <li>일최고체감온도 33℃이상인 상태가 2일 이상 지속될 것으로 예상될 때</li>
                                    <li>급격한 체감온도 상승 또는 폭염 장기화 등으로 중대한 피해발생이 예상될 때</li>
                                </ol>
                            </td>
                            <td>
                                폭염으로 인하여 다음 중 어느 하나에 해당하는 경우
                                <ol>
                                    <li>일최고체감온도 35℃이상인 상태가 2일 이상 지속될 것으로 예상될 때</li>
                                    <li>급격한 체감온도 상승 또는 폭염 장기화 등으로 광범위한 지역에서 중대한 피해발생</li>
                                </ol>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <!-- // 특보 -->

            <div id="impact" class="help-group">
                <h2 class="h2-help">영향예보</h2>
                <p>
                    영향예보란 같은 날씨에서도 때와 장소에 따라 다르게 나타나는 영향을 과학적인 자료를 바탕으로 예상하여, 상세한 기상정보와 함께 전달하는 예보를 말합니다.
                    현재 제공 중인 영향예보의 종류에는 폭염과 한파 영향예보가 있으며, 2021년부터는 태풍 영향예보를 시범운영 할 예정입니다.
                    영향예보는 기상 현상의 위험수준을 관심, 주의, 경고, 위험 4단계로 분류하며, 위험수준에 따라 차별화된 대응요령을 제공합니다.
                </p>
                <p><label>표출 영역</label> 남한 육상 </p>
                <ul class="help-list">
                    <li>
                        <label>영향예보 종류</label>폭염, 한파(2종)
                    </li>
                    <li>
                        <label>위험수준 단계</label>관심, 주의, 경고, 위험(4단계)
                    </li>
                </ul>
                <table class="help-table">
                <caption>영향예보 발표 기준에 대한 도움말을 제공한다.</caption>
                    <thead>
                    	<tr>
	                        <th>구분</th>
	                        <th>주의보</th>
                    	</tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>
                                <span class="sign concern"></span>
                                관심
                            </th>
                            <td>
                                일상적인 활동이 조금 불편한 수준으로, 취약한 대상에서는 일부 피해가 예상되는 수준
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <span class="sign care"></span>
                                주의
                            </th>
                            <td>
                                해당 지역 일부에서 다소 피해가 예상되는 수준
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <span class="sign warn"></span>
                                경고
                            </th>
                            <td>
                                해당 지역 곳곳에서 현저한 피해가 나타나 영향이 단기간 지속될 것으로 예상되는 수준
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <span class="sign danger"></span>
                                위험
                            </th>
                            <td>
                                해당 지역 대부분에 피해가 있고, 곳곳에 극심한 피해가 나타나 영향이 장기간 지속될 것으로 예상되는 수준
                            </td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <!-- // 영향예보 -->

            <div id="short" class="help-group">
                <h2 class="h2-help">초단기예측</h2>
                <h3 class="h3-help">육해상예측</h3>
                <p>초단기 강수 예측 자료는 KLFS 모델자료를 기반으로한 예측 자료입니다.</p>
                <p><label>표출 영역 </label>N30~44, E118~134</p>
                <ul class="help-list">
                    <li>
                        <label>강수예측</label>10분 단위 간격 6시간 예측자료입니다.
                    </li>
                </ul>
                <h3 class="h3-help">바다예측</h3>
                <p>초단기 해상풍 예측 자료는 KLFS 모델자료를, 초단기 유의파고 실황은 WANL자료, 예측자료는 KWW3모델자료를 , 해양시정자료는 LDPS모델자료를 기반으로한 예측 자료입니다.</p>
                <p><label>표출 영역 </label>N30~44, E118~134</p>
                <ul class="help-list">
                    <li>
                        <label>해상풍</label>1시간 단위 간격 12시간 예측 자료입니다.
                    </li>
                    <li>
                        <label>유의파고</label>1시간 단위 간격 12시간 예측 자료입니다.
                    </li>
                    <li>
                        <label>해양시정</label>1시간 단위 간격 48시간 예측자료입니다.
                    </li>
                </ul>
                
            </div>
            <!-- // 초단기예측 -->

            <div id="marine" class="help-group">
                <h2 class="h2-help">해구예측</h2>
                <p>
                    기상청의 지역파랑예측모델의 예측값을 활용하여 수협중앙회에서 어업인 교육용으로 제작(2010.12월)된 해구도를 기반으로 해구별 예측자료를 생산 합니다.
                </p>
                <p><label>표출 영역 </label>N25~46, E119~140</p>
                <ul class="help-list">
                    <li>
                        <label>예측시간</label>3시간 단위 간격으로 72시간까지 
                    </li>
                    <li>
                        <label>생산변수</label>유의파고(m), 파향(deg), 최대파주기(sec), 풍향(deg),풍속(m/s)
                    </li>
                    <li>
                        <label>생산주기</label>1일 2회(00UTC, 12 UTC)
                    </li>
                    <li>
                        <span class="help-tag">주의</span> 수치예측결과이므로 예보와 상이할 수 있습니다. 
                    </li>
                </ul>
            </div>
            <!-- // 해구예측 -->

            <div id="load" class="help-group">
                <h2 class="h2-help">도로기상</h2>
                <h3 class="h3-help">어는비</h3>
                <p>
                    1시간 간격 12시간까지
                    온도는 영하이지만 물방울 상태(과냉각상태)로 내리는 비를 의미합니다.
                    도로면의 온도가 영하일 때 어는비가 내리면, 도로에 닿자마자 얼어붙어 도로 살얼음의 원인이 될 수 있습니다.
                </p>
                <p><label>표출 영역 </label>남한 육상</p>
                
                <ol class="help-list" >
                    <li>
                        강수 발생
                    </li>
                    <li>
                        지면으로부터 약1km 정도 상공(925hPa)의 기온 0℃ 이상
                    </li>
                    <li>
                        3가지 조건을 모두 만족할 경우 지도에 해당 단계의 색으로 표출됩니다.
                        <ul class="help-list-sub">
                            <li> <span class="sign fst"></span> 1단계 : 지상 기온 2℃ 이하</li>
                            <li> <span class="sign snd"></span> 2단계 : 1℃ 이하 </li>
                            <li> <span class="sign trd"></span> 3단계 : 0℃ 이하</li>
                        </ul>
                    </li>
                </ol>
               
            </div>
            <!-- // 도로기상 -->
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div id="timebar" class="timebar loaded" v-show="display">
        <div v-if="dateList.length>1">
            <!-- date는 일, 요일, 시간만 필요// 년, 월은 필요없음 -->
            <span class="date" v-if="dateList.length>0">{{dateFormat.format(displayDate)}}</span>
        </div>
        <div v-if="dateList.length>1">
            <button type="button" title="재생" class="time play" v-on:click="play()" v-show="!playing">재생</button>
            <button type="button" title="일시정지" class="time pause" v-on:click="stop()" v-show="playing">정지</button>
        </div>
        <div v-if="dateList.length>1">
            <input type="range" class="range" min="0" v-bind:max="dateList.length-1" v-model="value" v-on:change="setIndex(value)" step=1>
        </div>
        <div v-if="dateList.length>1">
            <select v-model="interval" v-on:change="changeInterval()">
                <option value="500" selected>X1</option>
                <option value="250">X2</option>
                <option value="125">X4</option>
            </select>
        </div>
        <!-- TODO: css 수정 필요. div를 한겹 감싸는 경우 css가 깨짐 -->
        <div v-if="dateList.length == 1" style="height: 46px; flex:1 1 auto; white-space: nowrap; text-align: center;">
        	<span class="date" v-if="dateList.length>0">{{dateFormat.format(displayDate)}}</span>
        </div>
    </div>

    <script src='/wgis-nuri/js/map/timebar.js?v=202111121900'></script>
    <!-- Spinner -->
    <div id="modal" class="modal">
        <dialog id="progress"></dialog>
    </div>

    <!-- 관측 지점 정보 팝업 -->
    <div id="obsPopup" class="layer-center loaded" v-show="display">
        <button id="close" @click="close()">X</button>
        <div class="basic">
            <p class="ko">{{ name }}</p>
            <p class="coord">{{ Number(coord[0]).toFixed(5) }}, {{ Number(coord[1]).toFixed(5) }}</p>
        </div>
        <p class="tm">관측 시각: {{ tm }}</p>

        <table v-if="item.type === type" v-for="(item, index) in items" summary="관측 지점의 상세 정보를 표출한다.">
            <tr v-for="(data, index) in item.table">
                <th scope="row"><label>{{ data["label"] }}</label></th>
                <td>
                	<template v-if="data.unit == 'm/s' && typeof(data['value']) === 'number'">{{ Number((data["value"] * config.unitValue).toFixed(1)) }}  {{ config.unit }}</template>
                	<template v-else="data.unit == 'km/h'">{{ data["value"] }}  {{ data["unit"] }}</template>
                </td>
            </tr>
        </table>
        <button v-if="type === 'air'" class="time-view air" v-on:click="getTimeSeries" title="예보보기">예보보기</button>
    </div>

    <!-- 동네예보 지점 정보 팝업 -->
    <div id="dfsPopup" class="popup dsfp loaded" v-show="display">
        <button class="dsfp-close" @click="close()">닫기</button>
        <p v-if="dongName !== ''" class="dsfp-name">{{ dongName }}</p>
        <p v-else class="dsfp-name"><span>{{ dispCoord[0] }}</span><span>{{ dispCoord[1] }}</span></p>
        <span class="dsfp-info" v-if="element.indexOf('VEC') > -1">
            {{ value }}
            <img src="../images/weather/VEC.png" :style="getVecStyle(value)" alt="풍향">
        </span>
        <span class="dsfp-info" v-if="element === 'WSD'">{{ getWsd(value) }} {{ config.unit }}</span>
        <span class="dsfp-info" v-else>{{ value }}</span>
        <button class="time-view" v-on:click="getTimeSeries" title="예보보기">예보보기</button>
    </div>
    
	<!-- 해구별예측 지점 정보 팝업 -->
    <div id="rwwPopup" class="popup dsfp loaded" v-show="display">
        <button class="dsfp-close" @click="close()">닫기</button>
        <p class="dsfp-name">{{ zoneId }}</p>
        <span class="dsfp-info-small">유의파고: {{ b }}m</span>
        <span class="dsfp-info-small">파향: {{ cl }}</span>
        <span class="dsfp-info-small">파주기: {{ d }}s</span>
        <span class="dsfp-info-small">풍속: {{ Number((e * config.unitValue).toFixed(1)) }} {{config.unit}}</span>
        <span class="dsfp-info-small">풍향: {{ fl }}</span>
        <button class="time-view" v-on:click="getTimeSeries" title="예측보기">예측보기</button>
    </div>
    
    <!-- 정보 지연 알림 팝업 -->
    <div id="information" class="layer-center loaded" v-show="display">
        <p class="info">{{ msg }}</p>
    </div>

    <!-- // GNB -->
    <div id="nav">
        <div :class="nav">
            <!-- // ACCORDION -->
            <div class="navBtn">
                <button class="navClose" @click="close()">메뉴접기</button>
                <button type="button" title="새로고침" class="reset" v-on:click="reload()">새로고침</button>
            </div>
            <ul class="accordion">
                <li v-for="(menu, index) in menus"  :class="menu.unfold" v-if="menu.visible"><!-- 클릭시 li class="on" 하위메뉴 펼쳐짐 -->
                    <p v-on:click="foldUnfold(index, menu)">{{ menu.title }}</p>
                    <ul>
                        <li v-if="menu.opacity">
                            <input type="range" min="0" max="1" step="0.1" v-model:value="menu.opacity"
                                    v-on:change="setOpacity(menu.id, menu.opacity)" style="width: 80px;"> {{ menu.opacity * 10}}
                        </li>
                        <li v-for="(child, cIndex) in menu.children" v-if="child.visible" @click.self="clickCheck(menu, child)">
                            <label class="switch" @click.self.prevent="clickCheck(menu, child)">
                                <input type="checkbox" v-model:checked="child.checked" >
                                <span class="slider round" @click.self.prevent="clickCheck(menu, child)"></span>
                            </label>{{ child.title }}
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- // NAV -->
        <!-- 작업메모 // NAV가 닫히면 navSum이 보임, div클릭하면 navSum숨기고 NAV 보임-->
        <div :class="navSum" >
			<div class="navBtn">
                <button type="button" title="메뉴" class="extend" @click="close()">메뉴펼치기</button>
                <button type="button" title="새로고침" class="reset" @click="reload()">새로고침</button>
            </div>
            <div class="navSumWrap">
	            <ul v-for="(title, index) in titles">
	                <li>{{ title }}</li>
	            </ul>
	    	</div>
        </div>
    </div>

    <!-- 동네예보 시계열표 -->
    <div id="dfsTimeSeries">
        <div class="timeseries-date container section loaded" v-show="isOpen">
            <div class="title scroll-x">
                <div>
                    <button id="dfsBookMark" type="button" v-if="bookmark != null" class="bookmark" v-bind:class="{'on': isBookmark}" v-on:click="setBookmark()">관심지역</button>
                    <span class="tit" v-if="bookmark != null">{{ bookmark.fullName }}</span>
                    <span v-if="dispCoord.length > 0">({{ dispCoord[0] }}, {{ dispCoord[1] }})</span>
                    <span v-else>({{ dfsp.gridX }}, {{ dfsp.gridY }})</span>
                </div>
                <div>
                    <span class="tit wrn" v-if="wrn !== ''">특보 발효중</span><span>{{ wrn }}</span>
                </div>
                <div>
                    <span class="tit">업데이트</span>
                    <span class="time" v-show="position === 'land'">초단기: {{ titleFormat.format(vsrtFctDate) }}, </span>
                    <span class="time">동네예보: {{ titleFormat.format(shrtFctDate) }}</span>
                </div>
                <button type="button" v-on:click="closeSection(true)" class="close">닫기</button>
            </div>
            
            <div :class="{'itemWrap land': (position == 'land'), 'itemWrap sea': (position == 'sea')}">
                <!-- 좌측 타이틀 -->
                <div class="item-title" :class="'item-title-'+position">
                    <p class="nbsp">&nbsp;</p>
                    <p>{{ tmpElements["DATE"].kor }}</p>
                    <p v-for="key in elements" v-if="tmpElements[key] && key != 'VEC' && tmpElements[key].visible" :class="key+'title'">
                        <span>{{ tmpElements[key].kor }}</span>
                        <br v-if="key === 'WSD'">
                        <span v-if="key === 'WSD'">({{ config.unit }})</span>
                        <span v-else>{{ tmpElements[key].unit }}</span>
                        <button type="button" class="info" v-show="(key==='POP'||key==='SNO')" style="padding:0px;" v-on:click="setFocusInfo" :title="tmpElements[key].kor+'은 초단기가 제공되지 않습니다.'">정보</button>
                    </p>
                    <p v-if="position === 'land'">영향예보</p>
                </div>
                
                <!-- 시계열 표 -->
                <div class="slide scroll-x" v-if="dfsType==='SHRT3'">
			        



    <div class = "slide-data" :style="getSlideDataStyle()">
        <div class="item" :class="position" v-for="(item, index) in dfsp.dateList" :set="DFSP=dfsp.dfspValues">
            <!-- 날짜, 최고/최저기온 -->
            <div :class="['item-'+position, {'day-line' : (item.getHours() === 0 && index !== dfsp.dateList.length-1)}]" v-if="item != null">
                <div class="dateWrap" :style="getDateWrapStyle(index)" v-if="((item.getHours() === 0 || index === 0) && index !== dfsp.dateList.length-1)">
                    <span class="dayLine">
                        {{ dateFormat.format(item) }}
                    </span>
                    <div v-show="position==='land'" :class="{'both': (showTmxTmn('tmx', index)&&showTmxTmn('tmn', index))}" style="margin-left: -20px;">
                        <span v-show="showTmxTmn('tmn', index)" style="color: #009AE1">{{getTmxTmn('tmn',index)}}</span>
                        <span v-show="showTmxTmn('tmx', index) && showTmxTmn('tmn', index)">/</span>
                        <span v-show="showTmxTmn('tmx', index)" style="color: #db6200;">{{getTmxTmn('tmx',index)}}</span>
                    </div>
                </div>
                <div class="dateWrap" v-else >
                    <span>&nbsp;</span>
                </div>

                <!-- 시간 -->
                <div v-if="item != null" class="timeWrap">
                    <p v-if="index==dfsp.dateList.length-1 && position=='land'" style="width:30px;padding-left:30px;"> 24시 </p>
                    <p v-else-if="position=='land'" style="width:30px;padding-left:30px;" :class="{'green': (item < new Date(shrtStartDate))}"> {{ item.getHours()+"시" }} </p>
                    <p v-else-if="index==dfsp.dateList.length-1 && position=='sea'"> 24시 </p>
                    <p v-else-if="position=='sea'"> {{ item.getHours()+"시" }} </p>
                </div>

                <!-- 요소별 시계열 값 -->
                <div class="elementWrap" v-for="element in elements" v-if="item != null">
                    <div><!-- SKY 요소 -->
                        <p :class="getCss(index,element)" v-if="position==='land' && DFSP[element] != undefined && element === 'SKY'">
                            <img v-if="position==='land' && DFSP.PTY[index] != 0" :src="getImagePath('PTY',DFSP.PTY[index], item.getHours())" alt="하늘상태">
                            <img v-if="position==='land' && DFSP.PTY[index] === 0 && DFSP.SKY[index] != -999 && DFSP.SKY[index] != 0" :src="getImagePath('SKY',DFSP.SKY[index], item.getHours())" alt="하늘상태">
                            <img v-if="position==='land' && DFSP.PTY[index] === 0 && DFSP.SKY[index] === -999 && element === 'SKY'" src= "../images/weather/no.png" alt="하늘상태 없음">
                        </p>
                    </div>
                    <div><!-- VEC 요소 -->
                        <p :class="getCss(index,element)" v-if="DFSP[element] != undefined && element === 'VEC'">
                            <img v-if="DFSP.VEC[index] != -999 && getWsd(DFSP.WSD[index]) != 0" :src="getImagePath('VEC','', item.getHours())" :style="getVecStyle(DFSP.VEC[index])" alt="풍향">
                            <img v-else src= "../images/weather/no-vec.png" alt="풍향 없음">
                        </p>
                    </div>
                    <!-- 나머지 요소 -->
                    <div class="basic" v-if="DFSP[element] != undefined && element != 'SKY' && element != 'PTY' && element != 'VEC'">
                        <p :class="getCss(index,element)" v-if="DFSP[element][index] != -999 && !(element == 'WSD')">{{ DFSP[element][index] }}</p>
                        <p :class="getCss(index,element)" v-if="DFSP[element][index] != -999 && element == 'WSD'">{{ getWsd(DFSP[element][index]) }}</p>
                        <p :class="getCss(index,element)" v-if="DFSP[element][index] == -999">
                            <img src= "../images/weather/no.png" :class="getCss(index,element)" alt="없음">
                        </p>
                    </div>
                </div>
                <div class="basic">
                    <p v-if="position === 'land'" :class="getIfsCss(ifs[index])" :style="{width: (item.getHours() % 18 === 0 && item.getHours() !== 0 ? 50 : 55) + 'px'}">{{getIfs(index, item)}}</p>
                </div>
            </div>
        </div>
        <!-- 가까운 관측소 (모바일) -->
        <div :class="{'closestAws mobile': (position == 'land'), 'closestAws mobile sea-aws': (position == 'sea')}" v-if="closestAws != null" :set="aws=closestAws">
            <p class="awsTit">가까운 관측소</p>
            <p class="awsName">{{ aws.stnKo }}</p>
            <p class="awsCoo">{{ aws.coord[0] }}, {{ aws.coord[1] }}</p>
            <div class="awsData" v-if="aws.ta != null">
                <p class="awsTm">{{aws.tm.substr(0,4)}}.{{aws.tm.substr(4,2)}}.{{aws.tm.substr(6,2)}} {{aws.tm.substr(8,2)}}:{{aws.tm.substr(10, 2)}}</p>
                <p><span class="awsSubtit">거리</span> <span>{{ aws.distance.toFixed(2) }} km</span></p>
                <p><span class="awsSubtit">기온</span> <span>{{ aws.ta }} ℃</span></p>
                <p v-if="aws.rn"><span class="awsSubtit">강수량</span> <span>{{ aws.rn }} mm</span></p>
                <p><span class="awsSubtit">바람</span>
                    <img v-if="aws.wd != '-'" :src="getImagePath('VEC','', 0)" :style="getAwsWdStyle(aws.wd)" alt="풍향">
                    <span>{{ getWsd(aws.ws) }} {{ config.unit }}</span></p>
                <p v-if="aws.hm"><span class="awsSubtit">습도</span> <span>{{ aws.hm }} %</span></p>
            </div>
            <div class="awsData" v-else>
                <p style="text-align: center">관측 데이터 없음</p>
            </div>
        </div>
    </div>
                </div>
                <div class="slide scroll-x" v-if="dfsType==='SHRT1'">
			        



    <div class="slide-data" :class="{'winter': IS_WINTER}" :style="getSlideDataStyle()">
        <div :set="DFSP=dfsp.dfspValues">
            <div :set="DATE=dfsp.dateList">
                <div class="dfsWrap" :class="{'day-line': (di != 0 && di != DATE.length-1)}" :style="getDfsWrapWidth(dw)" 
                    v-for="(dw, di) in DATE" v-if="(dw.getHours() == 0 || di == 0)">
                    <div class="dfs-zone" v-if="di != DATE.length-1">
                        <span class="week" :class="{'empty': (dw.getHours() >= 23)} ">{{ dateFormat.format(dw) }}</span>
                        <span class="tmnx" v-show="showTmxTmn('tmn', di)" style="color: #009AE1">{{getTmxTmn('tmn', di)}}</span>
                        <span class="tmnx" v-show="showTmxTmn('tmx', di) && showTmxTmn('tmn', di)">/</span>
                        <span class="tmnx" v-show="showTmxTmn('tmx', di)" style="color: #db6200;">{{getTmxTmn('tmx', di)}}</span>
                    </div>

                    <div>
                        <div class="dfs-element" v-for="(d, i) in DATE" v-if="dw.getDate() == d.getDate()">
                            <div class="dfs time" :class="{'sea': (position !== 'land')}">
                                <span :class="{'green': (d < new Date(shrtStartDate))}">{{ getEfcDate(i) }}</span>
                            </div>

                            <div class="dfs" v-if="position==='land'">
                                <span style="margin-bottom:15px">
                                    <img class="sky" v-if="DFSP.PTY[i] != 0" :src="getImagePathPTY(DFSP.PTY[i])" alt="하늘상태">
                                    <img class="sky" v-if="DFSP.PTY[i] == 0 && DFSP.SKY[i] != -999 && DFSP.SKY[i] != 0" :src="getImagePathSKY(DFSP.SKY[i], DATE[i].getHours())" alt="하늘상태">
                                    <img class="sky" v-if="DFSP.PTY[i] == 0 && DFSP.SKY[i] == -999" src= "../images/weather/no.png" alt="하늘상태 없음">
                                </span>
                            </div>

                            <div class="dfs tmp" v-if="position === 'land'">
                                <span>{{ DFSP.TMP[i] }}</span>
                            </div>
                            <div class="dfs wct" v-if="position === 'land'">
                                <span>{{ DFSP.WCT[i] }}</span>
                            </div>
                            <div class="dfs pcp" v-if="position === 'land'">
                                <span class="box">{{ DFSP.PCP[i] }}</span>
                            </div>
                            <div class="dfs sno" v-if="IS_WINTER && position === 'land'">
                                <span class="box" :class="{'empty': (d < new Date(shrtStartDate))}">{{ DFSP.SNO[i] }}</span>
                            </div>
                            <div class="dfs pop" v-if="position === 'land'">
                                <span>{{ DFSP.POP[i] }}</span>
                            </div>
                            <div class="dfs wav" :class="{'sea': (position !== 'land')}" v-if="position !== 'land'">
                                <span>{{ DFSP.WAV[i] }}</span>
                            </div>
                            <div class="dfs vec" :class="{'sea': (position !== 'land')}">
                                <span>
                                    <img class="vec" v-if="DFSP.VEC[i] != -999 && getWsd(DFSP.WSD[i]) != 0" src="../images/weather/VEC.png" :style="getVecStyle(DFSP.VEC[i])" alt="풍향">
                                    <img class="vec" v-else src="../images/weather/no-vec.png" alt="풍향 없음">
                                </span>
                            </div>
                            <div class="dfs wsd" :class="{'sea': (position !== 'land')}">
                                <span :class="{'empty': (getWsd(DFSP.WSD[i]) == 0)}">{{ getWsd(DFSP.WSD[i]) }}</span>
                            </div>
                            <div class="dfs reh" v-if="position === 'land'">
                                <span>{{ DFSP.REH[i] }}</span>
                            </div>
                        </div>
                    </div>
                    
                </div><!-- dfsWrap -->
                <div class="ifs">
                    <span v-if="position === 'land'" v-for="(iv, j) in ifs" :class="getIfsCss(iv)">{{getIfs(j, DATE[j])}}</span>
                </div>
            </div>
        </div>
    </div>

                </div>

                <!-- 가까운 관측소 (PC) -->
                <div :class="{'closestAws': (position == 'land'), 'closestAws sea-aws': (position == 'sea')}" v-if="closestAws != null" :set="aws=closestAws">
                    <p class="awsTit">가까운 관측소</p>
                    <p class="awsName">{{ aws.stnKo }}</p>
                    <p class="awsCoo">{{ aws.coord[0] }}, {{ aws.coord[1] }}</p>
                    <div class="awsData" v-if="aws.ta != null">
                        <p class="awsTm">{{aws.tm.substr(0,4)}}.{{aws.tm.substr(4,2)}}.{{aws.tm.substr(6,2)}} {{aws.tm.substr(8,2)}}:{{aws.tm.substr(10, 2)}}</p>
                        <p><span class="awsSubtit">거리</span> <span>{{ aws.distance.toFixed(2) }} km</span></p>
                        <p><span class="awsSubtit">기온</span> <span>{{ aws.ta }} ℃</span></p>
                        <p v-if="aws.rn"><span class="awsSubtit">강수량</span> <span>{{ aws.rn }} mm</span></p>
                        <p><span class="awsSubtit">바람</span>
                            <img v-if="aws.wd != '-'" :src="getImagePath('VEC','', 0)" :style="getAwsWdStyle(aws.wd)" alt="풍향">
                            <span>{{ getWsd(aws.ws) }} {{ config.unit }}</span></p>
                        <p v-if="aws.hm"><span class="awsSubtit">습도</span> <span>{{ aws.hm }} %</span></p>
                    </div>
                    <div class="awsData" v-else>
                        <p style="text-align: center">관측 데이터 없음</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 해구별 예측 시계열표 -->
    <div id="rwwTimeSeries">
        <div class="timeseries-date container section loaded" v-show="isOpen">
            <div class="title">
                <div>
                    <span class="tit">[ {{zoneId}} ]</span>
                    <span class="time">해구별 예측 정보 {{ titleFormat.format(title) }} 발표</span>
                </div>
                <button type="button" v-on:click="closeSection(true)" class="close">닫기</button>
            </div>
            
            <div class="itemWrap">
                <!-- 좌측 타이틀 -->
                <div class="item-title item-title-rww">
                    <p class="blank"></p>
                    <p>{{ elements["a"].kor }}</p>
                    <p>{{ elements["f"].kor }} ({{elements["f"].unit }})</p>
                    <p>{{ elements["e"].kor }} ({{config.unit }})</p>
                    <p>{{ elements["b"].kor }} ({{elements["b"].unit }})</p>
                    <p>{{ elements["c"].kor }} ({{elements["c"].unit}})</p>
                    <p>{{ elements["d"].kor }} ({{elements["d"].unit }})</p>
                </div>
                <!-- 시계열 표 -->
                <div class="slide" style="height: 200px;">
                    <div class = "slide-data" :style="{width: (dateList.length * 55) + 'px'}">
                        <div class="item rww" v-for="(item, index) in dateList">
                        
                            <div v-if="item != null" class="item-land item-rww" :class="{'day-line' : (item.getHours() === 0 && index !== dateList.length-1)}">
                                <!-- 날짜 -->
                                <div class="dateWrap" v-if="isDatePosition(dateList, index)" :style="{marginLeft: (index === 0 ? 0 : 54) + 'px'}">
                                    <span style="background-color: #009AE1; border-radius: 3px; color: #fff; display: inline-block; padding: 0px 5px; width: 60px !important;">
                                        {{ dateFormat.format(item) }}
                                    </span>
                                </div>
                                <div class="dateWrap" v-else ><span>&nbsp;</span></div>

                                <!-- 시간 -->
                                <div v-if="item != null" class="timeWrap">
                                    <p class="blue"> {{ headerFormat.format(item) }} </p>
                                </div>
                                
								<div>
                                	<p><img src="../images/weather/VEC.png" :style="getVecStyle(dataList[index].f)" :title="dataList[index].f" alt="풍향"></p>
                                </div>
								<div>
                                	<p>{{  Number((dataList[index].e * config.unitValue).toFixed(1)) }}</p>
                                </div>
								<div>
                                	<p>{{  dataList[index].b }}</p>
                                </div>
								<div>
                                	<p><img src="../images/weather/VEC.png" :style="getVecStyle(dataList[index].c)" :title="dataList[index].c" alt="풍향"></p>
                                </div>
								<div>
                                	<p>{{  dataList[index].d }}</p>
                                </div>

                                <!-- 요소별 시계열 값 -->
                                <!-- <div class="elementWrap" v-for="element in elements" v-if="item != null">
                                    <div style="height: 20px; margin: 5px 0px 5.5px 0px;">
                                        <p>{{ item[element] }}</p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='/wgis-nuri/js/map/timeTable.js?v=202111121900'></script>

    <div id="legend" class="legend-position">
        <div v-for="(legend, key) in legends" class="legend" v-if="legend.display" v-show="!fold" v-on:click="foldUnfold()">
            <div class="legendWrap">
                <div class="co">
                    <div v-for="attr in legend.attributes" v-if="attr.visible"
                        v-bind:style="{width: legend.width + 'px', height: calcHeigth(legend) + 'px',
                                        margin: legend.margin + 'px', background: attr.color}"></div>
                </div>
                <div class="no" :class="legend.class">
                    <span v-for="attr in legend.attributes" v-if="attr.visible && attr.label">
                    	<template v-if="legend.unit == 'm/s'">{{ Number((attr.label * config.unitValue).toFixed(1)) }}</template>
                    	<template v-else>{{ attr.label }}</template>
                    </span>
                </div>
            </div>
            <div v-show="legend.unit && legend.unit != '없음'" class="unit">
            	<template v-if="legend.unit == 'm/s'">{{ config.unit }}</template>
                <template v-else>{{ legend.unit }}</template>
            </div>
        </div>
        <div class="legend-btn" v-show="fold" v-on:click="foldUnfold()"></div>
    </div>
    <script src='/wgis-nuri/js/map/legend.js?v=202111121900'></script>

	<script type="text/javascript">
		var mainMenu = "";
		var subMenu = "";
	</script>
    <!-- // NAVSUM -->
    <script src='/wgis-nuri/js/map/map.js?v=202111121900'></script>

    <div id="zoom" v-show=false class="layer loaded" style="left: 300px; bottom: 30px; z-index: 10; position: absolute; width: 200px;">
        <div v-if="display">
            <ul>
                <li> 줌 레벨: {{zoom}}, resolutions: {{resolutions}}</li>
                <li>L: <input type="text" name="left" v-model:value="left" v-on:change="change"></li>
                <li>B: <input type="text" name="bottom" v-model:value="bottom" v-on:change="change"></li>
                <li>R: <input type="text" name="right" v-model:value="right" v-on:change="change"></li>
                <li>T: <input type="text" name="top" v-model:value="top" v-on:change="change"></li>
                <li>
                    <button  v-on:click="change"> 적용 </button>
                    <button  v-on:click="visible">보이기/숨기기</button>
                    <button  v-on:click="draw(true)">영역그리기</button>
                    <button  v-on:click="draw(false)">여러번그리기</button>
                </li>
            </ul>
            <button type="button" class="" @click="show(false)">디버그 닫기</button>
        </div>
        <div v-if="!display">
            <button type="button" class="" @click="show(true)">디버그 조회</button>
        </div>
    </div>
    <script src='/wgis-nuri/js/map/debug.js?v=202111121900'></script>
    <div class="section" style="display: none; height: 300px; right: 38px; bottom: 10px;">섹션</div>
    <!-- // SECTION -->
    
    <script>
	    const unit = STORE.getItem("W_AC").unit;
	    EventBus.$emit('config', { unit: unit.ws, unitValue: unit.ws === "km/h" ? 3.6 : 1 });

	    // 맵모드 범례 접기
	    const mode = "";
	    legend.fold = (mode === "m" ? true : false);
    </script>
</div>
<!-- //WRAP -->
</body>
</html>