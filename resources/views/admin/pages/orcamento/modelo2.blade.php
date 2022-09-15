<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!-- 引入样式 -->
    <link rel="stylesheet" href="style/style.css">

    <style type="text/css" media="print">
        .noprint {
            display: none
        }
        
        .print {
            display: block !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <header class="el-header noprint">
            <div class="icon-btns">
                <i class="icon-list" @click="changeLeftMenu"></i>
                <i class="icon-skip_previous" v-bind:class="{'disabled': currentPage == 1}" @click="changeCurrentPage('first')"></i>
                <i class="icon-play_arrow prev-icon" v-bind:class="{'disabled': currentPage == 1}" @click="changeCurrentPage('prev')"></i>
                <i class="icon-play_arrow" v-bind:class="{'disabled': currentPage == pageNum}" @click="changeCurrentPage('next')"></i>
                <i class="icon-skip_next" v-bind:class="{'disabled': currentPage == pageNum}" @click="changeCurrentPage('last')"></i>
                <select v-model="currentPage">
                    <option v-for="page in pageNum" v-bind:value="page"></option>
                </select>
                <i class="icon-zoom_in" v-bind:class="{'disabled': zoomNum == 2}" @click="modifyZoom('in')"></i>
                <select v-model="zoomNum">
                    <option value="0.5">50%</option>
                    <option value="0.6">60%</option>
                    <option value="0.7">70%</option>
                    <option value="0.8">80%</option>
                    <option value="0.9">90%</option>
                    <option value="1.0" selected>100%</option>
                    <option value="1.1">110%</option>
                    <option value="1.2">120%</option>
                    <option value="1.3">130%</option>
                    <option value="1.4">140%</option>
                    <option value="1.5">150%</option>
                    <option value="1.6">160%</option>
                    <option value="1.7">170%</option>
                    <option value="1.8">180%</option>
                    <option value="1.9">190%</option>
                    <option value="2.0">200%</option>
                </select>
                <i class="icon-zoom_out" v-bind:class="{'disabled': zoomNum == 0.5}" @click="modifyZoom('out')"></i>
                <i class="icon-format_align_left" @click="textAlign = 'left'"></i>
                <i class="icon-format_align_center" @click="textAlign = 'center'"></i>
                <i class="icon-format_align_right" @click="textAlign = 'right'"></i>
                <i class="icon-print" @click="window.print()"></i>
            </div>
        </header>

        <aside class="noprint" width="240px" v-show="ifMenuShow">
            <nav class="tabNav">
                <ul>
                    <li v-bind:class="{ 'curr': currentNav == 0 }" @click="currentNav = 0">Page</li>
                    <li v-bind:class="{ 'curr': currentNav == 1 }" @click="currentNav = 1">Bookmark</li>
                </ul>

                <div class="clear"></div>
            </nav>

            <div class="tab-conent scrollbar" v-bind:style="{ height: asideHeight + 'px' }">

            <section v-show="currentNav == 0">
                <ul class="page-menu">
                    <li v-for="page in pageNum" v-bind:class="{ 'curr': currentPage == page }" @click="changePage(page)"><i class="icon-file-text2"></i> page</li>
                </ul>
            </section>

            <section v-show="currentNav == 1">
                <ul class="page-menu">
                    <li v-for="page in pageNum" v-bind:class="{ 'curr': currentPage == page }" @click="changePage(page)"><i class="icon-turned_in_not"></i> Bookmark</li>
                </ul>
            </section>
        </div>

        </aside>
        <div class="main scrollbar noprint"  v-bind:style="{ height: mainHeight + 'px' }" v-bind:class="{ 'mainLeftM': ifMenuShow, 'aleft': textAlign === 'left','acenter': textAlign === 'center','aright': textAlign === 'right'}">
            <div class="conent" v-html="pageContent" v-bind:style="zoomStyle"></div>

            <div class="clear"></div>
        </div>

        <!--专门只为打印的内容-->
        <div class="conent print" style="display:none" v-html="pageContent"></div>
    </div>
</body>
<!-- 先引入 Vue -->
<script src="js/vue.min.js"></script>
<script>

var app = new Vue({
        el: '#app',
        data: function() {
            return {
                // visible: false,
                isCollapse: false,
                currentNav: 0,
                activeName2: 'first',
                pageNum: 1, 
                currentPage: 1,
                pageContent: '',
                asideHeight: 300,
                mainHeight: 300,
                ifMenuShow: true,
                zoomNum: '1.0',
                textAlign: 'left',
                zoomStyle: {},
                pageDatas: ['<div style="position:absolute;top:0.000000px;left:0.000000px"><nobr><img height="1123.000000" width="794.000000" src ="bgimg/bg00001.jpg"/></nobr></div><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:943.131714px;left:438.815521px"><nobr>180 </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:958.114685px;left:435.864655px"><nobr>dias </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1001.143433px;left:438.815521px"><nobr>300 </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1016.126404px;left:435.864655px"><nobr>dias </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1063.616089px;left:438.815521px"><nobr>720 </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1078.598999px;left:435.864655px"><nobr>dias </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:939.629883px;left:488.499786px"><nobr>Cirurgias, Internações, Exames </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:953.614014px;left:488.499786px"><nobr>de alto custo, tratamento </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:967.598083px;left:488.499786px"><nobr>psicológico, terapia </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:981.582275px;left:488.499786px"><nobr>ocupacional, fisioterapia </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1009.183899px;left:488.499786px"><nobr>Parto </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1066.834351px;left:488.499786px"><nobr>Doenças e lesões </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1080.818481px;left:488.499786px"><nobr>Pré-Existentes </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:724.850586px;left:433.850647px"><nobr>24hs </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:10.633563px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1068.127686px;left:58.272137px"><nobr>180 </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:10.633563px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1081.112915px;left:55.680386px"><nobr>dias </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:782.862305px;left:433.850647px"><nobr>24hs </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:834.362488px;left:443.530640px"><nobr>90 </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:12.072354px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:849.345459px;left:435.864655px"><nobr>dias </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:714.945618px;left:485.389099px"><nobr>Urgência, Emergência e </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:728.929688px;left:485.389099px"><nobr>Acidentes Pessoais </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:10.073542px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:959.991943px;left:99.301231px"><nobr>Atendimento </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:10.073542px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:972.310791px;left:99.301231px"><nobr>Urgência/Emergência </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:10.633563px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:1011.935425px;left:62.297234px"><nobr>60 <span style="font-family:Microsoft Sans Serif;font-size:10.073542px;color:#FFFFFF;">Diagnóstico prevenção </span></nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:10.073542px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1036.572876px;left:99.301231px"><nobr>dentística </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:10.073542px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1066.518677px;left:99.301231px"><nobr>Demais procedimentos </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:10.073542px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1078.837402px;left:99.301231px"><nobr>odontológicos </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:772.957336px;left:485.389099px"><nobr>Consultas Médicas, </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:786.941406px;left:485.389099px"><nobr>Exames Médicos Simples </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:831.682861px;left:485.389099px"><nobr>Exames Cardiológicos e </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:11.435390px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:845.666992px;left:485.389099px"><nobr>de Alta Complexidade </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:8.183270px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:865.520996px;left:485.389099px"><nobr>Exames Cardiológicos (exceto PAC); </nobr></span></span></p><p><span style="font-family:Microsoft Sans Serif;font-size:8.183270px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:878.246765px;left:485.389099px"><nobr>Exames Oftalmológicos (exceto PAC). </nobr></span><span style="position:absolute;top:890.972473px;left:485.389099px"><nobr>Exames de otorrino simples (exceto PAC); </nobr></span><span style="position:absolute;top:903.698242px;left:485.389099px"><nobr>Exames de Raio-X contratados (exceto PAC); </nobr></span><span style="position:absolute;top:916.424072px;left:485.389099px"><nobr>Exames de ultrassonografia (exceto PAC) </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:654.800354px;left:46.887543px"><nobr>Valores de </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:673.778748px;left:46.887543px"><nobr>Coparticipação: </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:654.800354px;left:427.196198px"><nobr>Carências </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:673.778748px;left:427.196198px"><nobr>Saúde: </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:903.836670px;left:45.334419px"><nobr>Carências </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:922.815125px;left:45.334419px"><nobr>Odonto: </nobr></span></span></p><p><span style="font-family:Arial;font-size:21.724243px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:177.513916px;left:163.372528px"><nobr>ORÇAMENTO - GOIÂNIA E REGIÃO </nobr></span><span style="position:absolute;top:231.633545px;left:246.924591px"><nobr><span style="font-size:17.969107px;">Plano Coletivo por Adesão </span></nobr></span></span></p><p><span style="font-family:Arial;font-size:12.377817px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:360.712555px;left:67.765007px"><nobr>QTD FAIXA ETÁRIA APART </nobr></span></span></p><p><span style="font-family:Arial;font-size:12.377817px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:357.307129px;left:410.809143px"><nobr>ENFERM APART ENFERM </nobr></span></span></p><p><span style="font-family:Arial;font-size:12.377817px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:317.796478px;left:289.662933px"><nobr>COM COPARTICIPAÇÃO SEM COPARTICIPAÇÃO </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:406.687836px;left:171.571747px"><nobr>0 A 18 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:402.234375px;left:288.131775px"><nobr>R$ 98,00 R$ 98,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#FF5921;"><span style="position:absolute;top:400.472321px;left:532.742310px"><nobr>R$ 98,00 R$ 98,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:449.593140px;left:285.821045px"><nobr>R$ 127,00 R$ 127,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#FF5921;"><span style="position:absolute;top:448.943420px;left:530.431519px"><nobr>R$ 127,00 R$ 127,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:494.417969px;left:283.947479px"><nobr>R$ 398,98 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:540.165771px;left:283.276154px"><nobr>R$ 658,00 R$ 789,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#FF5921;"><span style="position:absolute;top:538.168091px;left:530.627075px"><nobr>R$ 587,00 R$ 2147,00 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:494.179749px;left:407.441284px"><nobr>R$ 398,98 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#FF5921;"><span style="position:absolute;top:494.417969px;left:529.473938px"><nobr>R$ 398,98 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:718.072754px;left:53.446625px"><nobr>Consultas Eletivas </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:758.132812px;left:52.204010px"><nobr>Consultas de Urgência </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:793.288879px;left:53.446625px"><nobr>Exames Simples </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:825.687378px;left:54.176975px"><nobr>Exames Complexos </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#FF5921;"><span style="position:absolute;top:494.417969px;left:651.991821px"><nobr>R$ 398,98 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:721.069458px;left:297.829712px"><nobr>R$ 11,10 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:754.170776px;left:293.248901px"><nobr>R$ 16,65 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:792.065674px;left:297.401794px"><nobr>R$ 9,99 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:826.601807px;left:292.116821px"><nobr>R$ 55,50 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:544.886841px;left:120.205269px"><nobr>TOTAL </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:406.973145px;left:78.582779px"><nobr>X </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:452.913666px;left:78.582779px"><nobr>X </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:498.219025px;left:79.308777px"><nobr>X </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.741813px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:589.680420px;left:48.255299px"><nobr>*No Plano Coletivo por Adesão <span style="font-family:Arial Unicode MS;">é </span><span style="font-family:Arial;">cobrado uma taxa mensal associativa de acordo com cada entidade (R$ 3,00 a 5,00) </span></nobr></span><span style="position:absolute;top:607.660034px;left:48.255299px"><nobr>*As carências valem a partir da data de vigência. </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:449.593140px;left:163.783508px"><nobr>19 A 23 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.989923px;font-weight:bold;color:#05355F;"><span style="position:absolute;top:495.498260px;left:162.440781px"><nobr>24 A 28 </nobr></span></span></p>','<div style="position:absolute;top:0.000000px;left:0.000000px"><nobr><img height="1123.000000" width="794.000000" src ="bgimg/bg00002.jpg"/></nobr></div><p><span style="font-family:Arial;font-size:12.776763px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:1013.496521px;left:196.746277px"><nobr>(62) 3097-5952 </nobr></span></span></p><p><span style="font-family:Arial;font-size:12.776763px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:1044.461304px;left:196.746277px"><nobr>accertplanosdesaude </nobr></span></span></p><p><span style="font-family:Arial;font-size:12.776763px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:1075.426025px;left:196.746277px"><nobr>www.accertsaude.com.br </nobr></span></span></p><p><span style="font-family:Arial;font-size:17.513790px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:470.779358px;left:151.468658px"><nobr>Site Oficial </nobr></span></span></p><p><span style="font-family:Arial;font-size:17.513790px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:528.351135px;left:151.468658px"><nobr>Segunda Via de Boleto </nobr></span></span></p><p><span style="font-family:Arial;font-size:17.513790px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:585.922913px;left:151.468658px"><nobr>Marcação de Consultas </nobr></span></span></p><p><span style="font-family:Arial;font-size:17.513790px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:643.494690px;left:151.468658px"><nobr>Rede de Atendimento </nobr></span></span></p><p><span style="font-family:Arial;font-size:18.047335px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:464.528442px;left:569.118408px"><nobr>Clínicas </nobr></span></span></p><p><span style="font-family:Arial;font-size:18.047335px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:524.357910px;left:569.118408px"><nobr>Hospitais </nobr></span></span></p><p><span style="font-family:Arial;font-size:18.047335px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:584.187378px;left:569.118408px"><nobr>Laboratórios </nobr></span></span></p><p><span style="font-family:Arial;font-size:18.047335px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:644.016846px;left:569.118408px"><nobr>Endereço </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.049230px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1049.406494px;left:559.622314px"><nobr>Consultor de Vendas </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.188585px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:988.627625px;left:514.745850px"><nobr>Clique aqui e Fale Comigo! </nobr></span><span style="position:absolute;top:1025.233032px;left:534.402283px"><nobr>Nome do Consultor </nobr></span></span></p><p><span style="font-family:Arial;font-size:14.467710px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:1072.258301px;left:546.764343px"><nobr>(00) 0000-0000 </nobr></span></span></p><p><span style="font-family:Arial;font-size:11.670735px;font-style:normal;font-weight:normal;color:#FFFFFF;"><span style="position:absolute;top:384.613617px;left:270.145752px"><nobr>Clique no ícone para ser Direcionado </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:33.785450px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:73.434410px;left:414.101471px"><nobr>Medicina </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:33.785450px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:117.101402px;left:414.101471px"><nobr>inteligente </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:33.785450px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:160.768311px;left:414.101471px"><nobr>com cuidados </nobr></span></span></p><p><span style="font-family:Gill Sans MT Ext Condensed;font-size:33.785450px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:204.435226px;left:414.101471px"><nobr>exclusivos! </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.475506px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:820.882629px;left:22.145250px"><nobr>SAÚDE - CONSULTAS E EXAMES </nobr></span><span style="position:absolute;top:836.760620px;left:22.145250px"><nobr>62 4002.3633 </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.475506px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:852.638672px;left:22.145250px"><nobr>62 4020-3633 </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.475506px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:903.597473px;left:22.145250px"><nobr>ODONTO - CONSULTAS E EXAMES </nobr></span><span style="position:absolute;top:919.475464px;left:22.145250px"><nobr>62 4002-2722 </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.485828px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:823.179565px;left:264.746338px"><nobr>FINANCEIRO </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.485828px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:838.984619px;left:264.746338px"><nobr>62 4020-9093 </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.485828px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:902.204773px;left:264.746338px"><nobr>CANCELAMENTO </nobr></span></span></p><p><span style="font-family:Arial;font-size:9.485828px;font-weight:bold;color:#FFFFFF;"><span style="position:absolute;top:918.009766px;left:264.746338px"><nobr>62 4020-1885 </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:753.571106px;left:22.145250px"><nobr>Telefones </nobr></span></span></p><p><span style="font-family:Arial;font-size:16.725943px;font-weight:bold;color:#FBB719;"><span style="position:absolute;top:772.549500px;left:22.145250px"><nobr>Hapvida: </nobr></span></span></p>']
            }
        },
        mounted: function() {
            this.$nextTick(function() {
                this.pageNum = this.pageDatas.length;
                this.pageContent = this.pageDatas[0];

                this.setLeftMenuHeight();
            })
        },
        watch: {
            'currentPage': function(newVal, oldValue) {
                // console.log('newVal ' + newVal, 'oldValue ' + oldValue);
                if (newVal) {
                    this.pageContent = this.pageDatas[this.currentPage - 1];
                }
            },
            'zoomNum': function(newVal, oldValue) {
                if (newVal) {
                    this.zoomStyle = {
                        'transform': 'scale(' + newVal + ')',
                        '-webkit-transform': 'scale(' + newVal + ')',
                        '-ms-transform': 'scale(' + newVal + ')',
                        '-moz-transform': 'scale(' + newVal + ')',
                        '-o-transform': 'scale(' + newVal + ')'
                    }
                }
            }
        },
        methods: {
            
            changeCurrentPage: function(methods) {
                switch (methods) {
                    case 'first':
                        this.currentPage = 1;
                        break;
                    case 'prev':
                        if (this.currentPage > 1) {
                            this.currentPage -= 1;
                        }
                        break;
                    case 'next':
                        if (this.currentPage < this.pageNum) {
                            this.currentPage += 1;
                        }
                        break;
                    case 'last':
                        this.currentPage = this.pageNum;
                        break;
                }
            },

            gotoPage: function(page) {
                console.log(page);
                this.currentPage = page;
            },
            modifyZoom: function(type) {
                switch (type) {
                    case 'in':
                        if (this.zoomNum < 2) {
                            // this.zoomNum = (this.zoomNum + 0.1).toFixed(1);
                            this.zoomNum = (parseFloat(this.zoomNum) + 0.1).toFixed(1);
                        }
                        break;
                    case 'out':
                        if (this.zoomNum > 0.5) {
                            this.zoomNum = (parseFloat(this.zoomNum) - 0.1).toFixed(1);
                        }
                        break;
                    default:
                        break;
                }
                console.log(this.zoomNum);
            },
            setLeftMenuHeight: function() {
                // this.asideHeight = document.body.scrollHeight - 60;
                this.mainHeight = document.documentElement.clientHeight - 60 - 20;
                // 60为头部导航高度， 46为menu高度， 40为上下padding
                this.asideHeight = this.mainHeight - 20 - 46;
            },
            changePage: function(page) {
                this.currentPage = page;
                // this.pageContent = this.pageDatas[page - 1];
            },
            changeLeftMenu: function() {
                this.ifMenuShow = !this.ifMenuShow;
            }
        }
    });

function gotoPage(page) {
    console.log(page);
    app.gotoPage(page);
}

</script>

</html>