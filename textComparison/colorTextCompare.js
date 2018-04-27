var textArray = [["Skymark provides various kinds of assistance so all customers can enjoy air travel.","스카이마크는 모든 고객님이 항공 여행을 즐길 수 있도록 다양한 지원 서비스를 제공합니다."],["For passengers requiring special assistance","도움이 필요한 승객 관련"],["Support at the departure airport","출발지 공항 서비스"],["In-flight Support","기내 서비스"],["Support at the arrival airport","도착지 공항 서비스"],["Regarding medical certificates and consent forms","진단서 및 동의서 양식 관련"],["Contact Address","고객센터 연락처"],["Notices to passengers requiring special assistance","도움이 필요한 승객을 위한 알림"],["We ask that the following customers who need assistance contact us. Please confirm prior to making a reservation and prior to travel.","다음과 같이 도움이 필요한 승객은 고객센터로 연락해 주시기 바랍니다. 여행을 예약하기 전에 확인해 주십시오."],["Customers with physical disabilities","신체가 불편하신 승객"],["For passengers using wheelchairs","휠체어를 이용하시는 승객"],["For visually impaired customers","시각 장애가 있는 승객"],["For customers with hearing impairments","청각 장애가 있는 승객"],["For passengers requiring an upper body support harness on board","상체 고정용 보조 벨트를 사용하시는 승객"],["Customers who are sick or injured","질병 또는 부상이 있는 승객"],["For passengers with illness or injury","질병 또는 부상이 있는 승객"],["Passengers using medical equipment in the cabin","기내에서 의료기기를 사용하시는 승객"],["Passengers who require dialysis treatment on flights","기내에서 인공투석을 하시는 승객"],["Passengers using medical oxygen bottles","의료용 산소 호흡기를 이용하시는 승객"],["For customers using a cardiac pacemaker or an implantable cardioverter defibrillator (ICD)","심장 박동기 또는 삽입형 심장 제세동기(ICD)를 사용하시는 승객"],["For customers using self-injectors","자가 의료용 주사기를 사용하시는 승객"]];
var colorArray = ["#F44336","#76FF03","#9C27B0","#FFEB3B","#3F51B5","#FFAB91","#03A9F4","#4CAF50","#009688","#E65100"];
var htmlLang = "en";
var lang = 0;
var htmlTreeArray = [];
var textNotFoundArray = textArray.slice();

console.log(textArray);
console.log(textNotFoundArray);


function getElementsWithText(){
	var a = [];
	$("*").each(function(){
		if($(this).children().length==0){
			a.push(this);
		}
	});
	return a;
}

htmlTreeArray = getElementsWithText();
htmlLang = $("html")[0].lang;
if(htmlLang == "en"){
	lang = 0;
}
else{
	lang = 1;
}

textArray.forEach(function(e,tIndex){
	var t = e[lang];
	var lock = false;
	var pinnedIndex = 0;
	for(var i = 0; i<htmlTreeArray.length; i++){
		if(t==$(htmlTreeArray[i])[0].innerText){
			$(htmlTreeArray[i]).wrap("<div style='background-color:"+colorArray[tIndex%10]+"'></div>");
			htmlTreeArray.splice(i,1);
			textNotFoundArray.splice(tIndex,1);
			break;
		}
	}
});
// console.log("text not found:");
// console.log(textNotFoundArray);