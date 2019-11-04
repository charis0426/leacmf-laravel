﻿var ChinaMap = {};

// 省份
ChinaMap.provinces = {
    "台湾": "taiwan",
    "河北": "hebei",
    "山西": "shanxi",
    "辽宁": "liaoning",
    "吉林": "jilin",
    "黑龙江": "heilongjiang",
    "江苏": "jiangsu",
    "浙江": "zhejiang",
    "安徽": "anhui",
    "福建": "fujian",
    "江西": "jiangxi",
    "山东": "shandong",
    "河南": "henan",
    "湖北": "hubei",
    "湖南": "hunan",
    "广东": "guangdong",
    "海南": "hainan",
    "四川": "sichuan",
    "贵州": "guizhou",
    "云南": "yunnan",
    "陕西": "shanxi1",
    "甘肃": "gansu",
    "青海": "qinghai",
    "新疆": "xinjiang",
    "广西": "guangxi",
    "内蒙古": "neimenggu",
    "宁夏": "ningxia",
    "西藏": "xizang",
    "北京": "beijing",
    "天津": "tianjin",
    "上海": "shanghai",
    "重庆": "chongqing",
    "香港": "xianggang",
    "澳门": "aomen"
};
// 省份编号（城市编号前两位关联）
ChinaMap.provinceCodes = {
    '11': '北京',
    '12': '天津',
    '13': '河北',
    '14': '山西',
    '15': '内蒙古',
    '21': '辽宁',
    '22': '吉林',
    '23': '黑龙江',
    '31': '上海',
    '32': '江苏',
    '33': '浙江',
    '34': '安徽',
    '35': '福建',
    '36': '江西',
    '37': '山东',
    '41': '河南',
    '42': '湖北',
    '43': '湖南',
    '44': '广东',
    '45': '广西',
    '46': '海南',
    '50': '重庆',
    '51': '四川',
    '52': '贵州',
    '53': '云南',
    '54': '西藏',
    '61': '陕西',
    '62': '甘肃',
    '63': '青海',
    '64': '宁夏',
    '65': '新疆',
    '71': '台湾',
    '81': '香港',
    '82': '澳门',
};
// 城市编号 
ChinaMap.cityCodes = {
    "北京市": "110100",
    "天津市": "120100",
    "上海市": "310100",
    "重庆市": "500100",
    "崇明县": "310200",
    "湖北省直辖县市": "429000",
    "铜仁市": "522200",
    "毕节市": "522400",
    "石家庄市": "130100",
    "唐山市": "130200",
    "秦皇岛市": "130300",
    "邯郸市": "130400",
    "邢台市": "130500",
    "保定市": "130600",
    "张家口市": "130700",
    "承德市": "130800",
    "沧州市": "130900",
    "廊坊市": "131000",
    "衡水市": "131100",
    "太原市": "140100",
    "大同市": "140200",
    "阳泉市": "140300",
    "长治市": "140400",
    "晋城市": "140500",
    "朔州市": "140600",
    "晋中市": "140700",
    "运城市": "140800",
    "忻州市": "140900",
    "临汾市": "141000",
    "吕梁市": "141100",
    "呼和浩特市": "150100",
    "包头市": "150200",
    "乌海市": "150300",
    "赤峰市": "150400",
    "通辽市": "150500",
    "鄂尔多斯市": "150600",
    "呼伦贝尔市": "150700",
    "巴彦淖尔市": "150800",
    "乌兰察布市": "150900",
    "兴安盟": "152200",
    "锡林郭勒盟": "152500",
    "阿拉善盟": "152900",
    "沈阳市": "210100",
    "大连市": "210200",
    "鞍山市": "210300",
    "抚顺市": "210400",
    "本溪市": "210500",
    "丹东市": "210600",
    "锦州市": "210700",
    "营口市": "210800",
    "阜新市": "210900",
    "辽阳市": "211000",
    "盘锦市": "211100",
    "铁岭市": "211200",
    "朝阳市": "211300",
    "葫芦岛市": "211400",
    "长春市": "220100",
    "吉林市": "220200",
    "四平市": "220300",
    "辽源市": "220400",
    "通化市": "220500",
    "白山市": "220600",
    "松原市": "220700",
    "白城市": "220800",
    "延边朝鲜族自治州": "222400",
    "哈尔滨市": "230100",
    "齐齐哈尔市": "230200",
    "鸡西市": "230300",
    "鹤岗市": "230400",
    "双鸭山市": "230500",
    "大庆市": "230600",
    "伊春市": "230700",
    "佳木斯市": "230800",
    "七台河市": "230900",
    "牡丹江市": "231000",
    "黑河市": "231100",
    "绥化市": "231200",
    "大兴安岭地区": "232700",
    "南京市": "320100",
    "无锡市": "320200",
    "徐州市": "320300",
    "常州市": "320400",
    "苏州市": "320500",
    "南通市": "320600",
    "连云港市": "320700",
    "淮安市": "320800",
    "盐城市": "320900",
    "扬州市": "321000",
    "镇江市": "321100",
    "泰州市": "321200",
    "宿迁市": "321300",
    "杭州市": "330100",
    "宁波市": "330200",
    "温州市": "330300",
    "嘉兴市": "330400",
    "湖州市": "330500",
    "绍兴市": "330600",
    "金华市": "330700",
    "衢州市": "330800",
    "舟山市": "330900",
    "台州市": "331000",
    "丽水市": "331100",
    "合肥市": "340100",
    "芜湖市": "340200",
    "蚌埠市": "340300",
    "淮南市": "340400",
    "马鞍山市": "340500",
    "淮北市": "340600",
    "铜陵市": "340700",
    "安庆市": "340800",
    "黄山市": "341000",
    "滁州市": "341100",
    "阜阳市": "341200",
    "宿州市": "341300",
    "六安市": "341500",
    "亳州市": "341600",
    "池州市": "341700",
    "宣城市": "341800",
    "福州市": "350100",
    "厦门市": "350200",
    "莆田市": "350300",
    "三明市": "350400",
    "泉州市": "350500",
    "漳州市": "350600",
    "南平市": "350700",
    "龙岩市": "350800",
    "宁德市": "350900",
    "南昌市": "360100",
    "景德镇市": "360200",
    "萍乡市": "360300",
    "九江市": "360400",
    "新余市": "360500",
    "鹰潭市": "360600",
    "赣州市": "360700",
    "吉安市": "360800",
    "宜春市": "360900",
    "抚州市": "361000",
    "上饶市": "361100",
    "济南市": "370100",
    "青岛市": "370200",
    "淄博市": "370300",
    "枣庄市": "370400",
    "东营市": "370500",
    "烟台市": "370600",
    "潍坊市": "370700",
    "济宁市": "370800",
    "泰安市": "370900",
    "威海市": "371000",
    "日照市": "371100",
    "莱芜市": "371200",
    "临沂市": "371300",
    "德州市": "371400",
    "聊城市": "371500",
    "滨州市": "371600",
    "菏泽市": "371700",
    "郑州市": "410100",
    "开封市": "410200",
    "洛阳市": "410300",
    "平顶山市": "410400",
    "安阳市": "410500",
    "鹤壁市": "410600",
    "新乡市": "410700",
    "焦作市": "410800",
    "濮阳市": "410900",
    "许昌市": "411000",
    "漯河市": "411100",
    "三门峡市": "411200",
    "南阳市": "411300",
    "商丘市": "411400",
    "信阳市": "411500",
    "周口市": "411600",
    "驻马店市": "411700",
    "省直辖县级行政区划": "469000",
    "武汉市": "420100",
    "黄石市": "420200",
    "十堰市": "420300",
    "宜昌市": "420500",
    "襄阳市": "420600",
    "鄂州市": "420700",
    "荆门市": "420800",
    "孝感市": "420900",
    "荆州市": "421000",
    "黄冈市": "421100",
    "咸宁市": "421200",
    "随州市": "421300",
    "恩施土家族苗族自治州": "422800",
    "长沙市": "430100",
    "株洲市": "430200",
    "湘潭市": "430300",
    "衡阳市": "430400",
    "邵阳市": "430500",
    "岳阳市": "430600",
    "常德市": "430700",
    "张家界市": "430800",
    "益阳市": "430900",
    "郴州市": "431000",
    "永州市": "431100",
    "怀化市": "431200",
    "娄底市": "431300",
    "湘西土家族苗族自治州": "433100",
    "广州市": "440100",
    "韶关市": "440200",
    "深圳市": "440300",
    "珠海市": "440400",
    "汕头市": "440500",
    "佛山市": "440600",
    "江门市": "440700",
    "湛江市": "440800",
    "茂名市": "440900",
    "肇庆市": "441200",
    "惠州市": "441300",
    "梅州市": "441400",
    "汕尾市": "441500",
    "河源市": "441600",
    "阳江市": "441700",
    "清远市": "441800",
    "东莞市": "441900",
    "中山市": "442000",
    "潮州市": "445100",
    "揭阳市": "445200",
    "云浮市": "445300",
    "南宁市": "450100",
    "柳州市": "450200",
    "桂林市": "450300",
    "梧州市": "450400",
    "北海市": "450500",
    "防城港市": "450600",
    "钦州市": "450700",
    "贵港市": "450800",
    "玉林市": "450900",
    "百色市": "451000",
    "贺州市": "451100",
    "河池市": "451200",
    "来宾市": "451300",
    "崇左市": "451400",
    "海口市": "460100",
    "三亚市": "460200",
    "三沙市": "460300",
    "成都市": "510100",
    "自贡市": "510300",
    "攀枝花市": "510400",
    "泸州市": "510500",
    "德阳市": "510600",
    "绵阳市": "510700",
    "广元市": "510800",
    "遂宁市": "510900",
    "内江市": "511000",
    "乐山市": "511100",
    "南充市": "511300",
    "眉山市": "511400",
    "宜宾市": "511500",
    "广安市": "511600",
    "达州市": "511700",
    "雅安市": "511800",
    "巴中市": "511900",
    "资阳市": "512000",
    "阿坝藏族羌族自治州": "513200",
    "甘孜藏族自治州": "513300",
    "凉山彝族自治州": "513400",
    "贵阳市": "520100",
    "六盘水市": "520200",
    "遵义市": "520300",
    "安顺市": "520400",
    "黔西南布依族苗族自治州": "522300",
    "黔东南苗族侗族自治州": "522600",
    "黔南布依族苗族自治州": "522700",
    "昆明市": "530100",
    "曲靖市": "530300",
    "玉溪市": "530400",
    "保山市": "530500",
    "昭通市": "530600",
    "丽江市": "530700",
    "普洱市": "530800",
    "临沧市": "530900",
    "楚雄彝族自治州": "532300",
    "红河哈尼族彝族自治州": "532500",
    "文山壮族苗族自治州": "532600",
    "西双版纳傣族自治州": "532800",
    "大理白族自治州": "532900",
    "德宏傣族景颇族自治州": "533100",
    "怒江傈僳族自治州": "533300",
    "迪庆藏族自治州": "533400",
    "拉萨市": "540100",
    "昌都地区": "542100",
    "山南地区": "542200",
    "日喀则地区": "542300",
    "那曲地区": "542400",
    "阿里地区": "542500",
    "林芝地区": "542600",
    "西安市": "610100",
    "铜川市": "610200",
    "宝鸡市": "610300",
    "咸阳市": "610400",
    "渭南市": "610500",
    "延安市": "610600",
    "汉中市": "610700",
    "榆林市": "610800",
    "安康市": "610900",
    "商洛市": "611000",
    "兰州市": "620100",
    "嘉峪关市": "620200",
    "金昌市": "620300",
    "白银市": "620400",
    "天水市": "620500",
    "武威市": "620600",
    "张掖市": "620700",
    "平凉市": "620800",
    "酒泉市": "620900",
    "庆阳市": "621000",
    "定西市": "621100",
    "陇南市": "621200",
    "临夏回族自治州": "622900",
    "甘南藏族自治州": "623000",
    "西宁市": "630100",
    "海东地区": "632100",
    "海北藏族自治州": "632200",
    "黄南藏族自治州": "632300",
    "海南藏族自治州": "632500",
    "果洛藏族自治州": "632600",
    "玉树藏族自治州": "632700",
    "海西蒙古族藏族自治州": "632800",
    "银川市": "640100",
    "石嘴山市": "640200",
    "吴忠市": "640300",
    "固原市": "640400",
    "中卫市": "640500",
    "乌鲁木齐市": "650100",
    "克拉玛依市": "650200",
    "吐鲁番地区": "652100",
    "哈密地区": "652200",
    "昌吉回族自治州": "652300",
    "博尔塔拉蒙古自治州": "652700",
    "巴音郭楞蒙古自治州": "652800",
    "阿克苏地区": "652900",
    "克孜勒苏柯尔克孜自治州": "653000",
    "喀什地区": "653100",
    "和田地区": "653200",
    "伊犁哈萨克自治州": "654000",
    "塔城地区": "654200",
    "阿勒泰地区": "654300",
    "自治区直辖县级行政区划": "659000",
    "台湾省": "710000",
    "香港特别行政区": "810100",
    "澳门特别行政区": "820000"
};

ChinaMap.ChartList = {};

ChinaMap.VueObj = {};

// 根据名称加载地图
ChinaMap.loadMap = function (elementId, name, drill, map) {
    if(ChinaMap.VueObj.pageKey == 2){
        var mapData = JSON.parse(window.localStorage.getItem('mapData_index'));
    }else if(ChinaMap.VueObj.pageKey == 0){
        var mapData = JSON.parse(window.localStorage.getItem('mapdata_aevent'));
    }
    var myChart = this.ChartList[elementId];
    if (!myChart) {
        var ele = document.getElementById(elementId);
        myChart = echarts.init(ele);
        this.ChartList[elementId] = myChart;
        if (drill) {
            myChart.on("click", function (params) {
                //首页点击亮点
                if(params.seriesName == '散点'&& ChinaMap.VueObj.pageKey == 2){
                    console.log(params)
                    ChinaMap.VueObj.gName = params.data.gName
                    ChinaMap.VueObj.dv_title = params.data.title
                    //通过id和type查询下属的点位列表
                    ChinaMap.VueObj.device_list = true;
                    ChinaMap.VueObj.v_type = 0
                    ChinaMap.VueObj.queryDvList(params.data.id,params.data.type)
                }
                //智能分析页面
                else if(params.seriesName == '散点'&& ChinaMap.VueObj.pageKey == 0){
                    ChinaMap.VueObj.device_list = true;
                    ChinaMap.VueObj.gName = params.data.gName;
                    ChinaMap.VueObj.dv_title = params.data.title;
                    ChinaMap.VueObj.initPlugin();
                    ChinaMap.VueObj.aEventNew(params.data.id,params.data.type)
                }
                ChinaMap.loadMap(elementId, params.name);
            });
        }

        window.addEventListener("resize", function () {
            ChinaMap.ChartList[elementId].resize();
        });
    }
    if (name in this.provinceCodes) name = this.provinceCodes[name];
    for (var city in this.cityCodes) {
        if (this.cityCodes[city] === name) {
            name = city;
        }
    }
    if (name in this.provinces) {
        $('#path').html(ChinaMap.formatPath(elementId, name));
        for (var k in this.provinceCodes) {
            if (this.provinceCodes[k] === name) {
                ChinaMap.VueObj.gov_code = k;
            }
        }
        $.getJSON('/static/map_json/province/' + this.provinces[name] + '.json', function (data) {
            if (ChinaMap.VueObj.govcodes && ChinaMap.VueObj.govcodes.length > 0) {
                var newData = [];
                for (var i in ChinaMap.VueObj.govcodes) {
                    for (var j in data.features) {
                        if (data.features[j].properties.id == ChinaMap.VueObj.govcodes[i]) {
                            newData.push(data.features[j]);
                        }
                    }
                }
                data.features = newData;
                if (ChinaMap.VueObj.gov_code != ChinaMap.VueObj.govcode) {
                    ChinaMap.VueObj.govcode = ChinaMap.VueObj.gov_code;
                    ChinaMap.VueObj.sData();
                }
                //未连接socket 直接画地图
                echarts.registerMap(name, data);
                ChinaMap.renderMap(elementId, name, map);
            } else {
                ChinaMap.VueObj.$http.post("/admin/department/id/" + ChinaMap.VueObj.gov_code, {}, {emulateJSON: true})
                .then(function (res) {
                        if (res.body.code == 0) {
                            //变更组织机构ID
                            if (ChinaMap.VueObj.department_id !== res.body.data) {
                                ChinaMap.VueObj.govcode = ChinaMap.VueObj.gov_code;
                                ChinaMap.VueObj.sdata.aEventZNs = {};
                                ChinaMap.VueObj.department_id = res.body.data;
                                ChinaMap.VueObj.sData();
                                if (ChinaMap.VueObj.path && ChinaMap.VueObj.socketType == 1) {
                                    //关闭重连
                                    ChinaMap.VueObj.socket.close();
                                    ChinaMap.VueObj.socketInit();
                                    return;
                                } else {
                                    //未连接socket 直接画地图
                                    echarts.registerMap(name, data);
                                    ChinaMap.renderMap(elementId, name, map);
                                }
                            } else {
                                // 重复请求 直接画地图
                                echarts.registerMap(name, data);
                                ChinaMap.renderMap(elementId, name, map);
                            }
                        } else {
                            // 没获取到组织机构ID 直接画地图
                            echarts.registerMap(name, data);
                            ChinaMap.renderMap(elementId, name, map);
                        }
                    }, function (res) {
                        // 请求出错 直接画地图
                        echarts.registerMap(name, data);
                        ChinaMap.renderMap(elementId, name, map);
                    }
                )
            }
        });
    } else if (name in this.cityCodes) {
        $('#path').html(ChinaMap.formatPath(elementId, name));
        ChinaMap.VueObj.gov_code = this.cityCodes[name];
        $.getJSON('/static/map_json/city/' + this.cityCodes[name] + '.json', function (data) {
            ChinaMap.VueObj.$http.post("/admin/department/id/" + ChinaMap.VueObj.gov_code, {}, {emulateJSON: true})
                .then(function (res) {
                        if (res.body.code == 0) {
                            if (ChinaMap.VueObj.department_id != res.body.data) {
                                //变更组织机构ID
                                ChinaMap.VueObj.govcode = ChinaMap.VueObj.gov_code;
                                ChinaMap.VueObj.sdata.aEventZNs = {};
                                ChinaMap.VueObj.department_id = res.body.data;
                                ChinaMap.VueObj.sData();
                                if (ChinaMap.VueObj.path && ChinaMap.VueObj.socketType == 1) {
                                    //关闭重连
                                    ChinaMap.VueObj.socket.close();
                                    ChinaMap.VueObj.socketInit();
                                    return;
                                } else {
                                    //未连接socket 直接画地图
                                    echarts.registerMap(name, data);
                                    ChinaMap.renderMap(elementId, name, map);
                                }
                            } else {
                                // 重复请求 直接画地图
                                echarts.registerMap(name, data);
                                ChinaMap.renderMap(elementId, name, map);
                            }
                        } else {
                            // 没获取到组织机构ID 直接画地图
                            echarts.registerMap(name, data);
                            ChinaMap.renderMap(elementId, name, map);
                        }
                    }, function (res) {
                        // 请求出错 直接画地图
                        echarts.registerMap(name, data);
                        ChinaMap.renderMap(elementId, name, map);
                    }
                )
        });
    } else if (name == 'china') {
        $('#path').html(ChinaMap.formatPath(elementId, name));
        ChinaMap.VueObj.gov_code = 'china';
        $.getJSON('/static/map_json/china.json', function (data) {
            if (ChinaMap.VueObj.govcode && ChinaMap.VueObj.govcode != 'china') {
                ChinaMap.VueObj.govcode = 'china';
                ChinaMap.VueObj.department_id = 1;
                ChinaMap.VueObj.sdata.aEventZNs = {};
                ChinaMap.VueObj.sData();
                if (ChinaMap.VueObj.path && ChinaMap.VueObj.socketType == 1) {
                    //关闭重连
                    ChinaMap.VueObj.socket.close();
                    ChinaMap.VueObj.socketInit();
                    return;
                } else {
                    echarts.registerMap('china', data);
                    ChinaMap.renderMap(elementId, 'china',map);
                }
            } else {
                echarts.registerMap('china', data);
                ChinaMap.renderMap(elementId, 'china',map);
            }

        });
    }

    return myChart;
};

ChinaMap.formatPath = function (elementId, name) {
    if (name in this.provinces) {
        return "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"china\")'>中国</a>" + '-' + "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"" + name + "\")'>" + name + "</a>";
    } else if (name in this.cityCodes) {
        var code = this.cityCodes[name].substr(0, 2);
        if (code in this.provinceCodes) {
            return "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"china\")'>中国</a>" + '-' + "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"" + this.provinceCodes[code] + "\")'>" + this.provinceCodes[code] + "</a>" + '-' + "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"" + name + "\")'>" + name + "</a>";
        } else {
            return "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"china\")'>中国</a>" + '-' + "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"" + name + "\")'>" + name + "</a>";
        }
    } else if (name == 'china') {
        return "<a href='javascript:;' onclick='ChinaMap.loadMap(\"" + elementId + "\", \"china\")'>中国</a>";
    }
};

ChinaMap.renderMap = function (elementId, name, map=[]) {

    var myChart = this.ChartList[elementId];
    if (!myChart) return;

    var data = [];
    var geoCoordMap = {};
    /*获取地图数据*/
    myChart.showLoading();
    var mapFeatures = echarts.getMap(name).geoJson.features;
    myChart.hideLoading();
    map.forEach(function (v) {
        if(v.lat != '"0.0000000"' && v.lnt != "0.0000000") {
            // 地区名称
            var name = v.name;
            // 地区经纬度
            geoCoordMap[name] = [v.lnt, v.lat];
            data.push({
                name: name,
                id:v.id,
                value:100,
                type:v.type,
                gName:v.dname,
            })
        }
    });

    var convertData = function (data) {
        var res = [];
        for (var i = 0; i < data.length; i++) {
            var geoCoord = geoCoordMap[data[i].name];
            if (geoCoord) {
                res.push({
                    name: "",
                    type:data[i].type,
                    title:data[i].name,
                    value: geoCoord.concat(data[i].value),
                    id:data[i].id,
                    gName:data[i].gName
                });
            }
        }
        return res;
    };
    var toolTipData = [];
    if(ChinaMap.VueObj.pageKey == 2){
        var mapData = JSON.parse(window.localStorage.getItem('mapData_index'));
    }else if(ChinaMap.VueObj.pageKey == 0){
        var mapData = JSON.parse(window.localStorage.getItem('mapdata_aevent'));
    }
    if (mapData && mapData.length > 0) toolTipData = mapData;

    var mapOption = {
        title: {
            text: name,
            left: 'center',
            textStyle: {
                color: 'blue',
                fontSize: 14,
                fontWeight: 'normal'
            }
        },
        tooltip: {
            padding: 0,
            enterable: true,
            transitionDuration: 1,
            textStyle: {
                color: '#000',
                decoration: 'none',
            },
            formatter: function (params) {
                var tipHtml = '';
                var title ='';
                if(params.data != undefined){
                    if(params.data['title'] !== undefined) {
                        title = params.data.title
                    }
                }else{
                    title = params.name;
                }
                tipHtml = '<div style="width:280px;background:rgba(22,80,158,0.8);border:1px solid rgba(7,166,255,0.7)">'
                    + '<div style="width:240px;height:40px;line-height:40px;border-bottom:2px solid rgba(7,166,255,0.7);padding:0 20px">' + '<i style="display:inline-block;width:8px;height:8px;background:#16d6ff;border-radius:40px;">' + '</i>'
                    + '<span style="margin-left:10px;color:#fff;font-size:16px;">' + title + '</span>' + '</div>';
                if (mapData && mapData.length > 0 && ChinaMap.VueObj.pageKey == 0) {
                    var strHtml = ' <div style="padding:20px;padding-top:0px">';
                    for (var i in toolTipData) {
                        if (params.name === toolTipData[i].name) {
                            for (var j in toolTipData[i].eventType) {
                                strHtml += '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                                    + toolTipData[i].eventType[j].Name + '<span style="color:#11ee7d;margin:0 6px;">' + toolTipData[i].eventType[j].Value + '</span>' + '个' + '</p>';
                            }
                        }
                    }
                    tipHtml += strHtml + '</div>' + '</div>';
                }
                else if(mapData && mapData.length > 0 && ChinaMap.VueObj.pageKey == 2){
                    for (var i in toolTipData) {
                        if (params.name === toolTipData[i].name && toolTipData[i].trans != 0) {
                            var strHtml =  '<div style="padding:20px;padding-top:0px"><p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                                + '已接转运中心数量：' + '<span style="color:#11ee7d;margin:0 6px;">' + toolTipData[i].trans + '</span>' + '个' + '</p>'
                                + '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                                + '视频巡检事件：' + '<span style="color:#f48225;margin:0 6px;">' +  toolTipData[i].xj + '</span>' + '个' + '</p>'
                                + '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                                + '智能分析事件：' + '<span style="color:#f4e925;margin:0 6px;">' + toolTipData[i].zy + '</span>' + '个' + '</p>'
                            tipHtml += strHtml + '</div>' + '</div>';
                        }
                    }
                }
                else{
                    tipHtml += '<div style="padding:20px;padding-top:0px">'
                        + '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                        + '已接转运中心数量：' + '<span style="color:#11ee7d;margin:0 6px;">' + toolTipData.length + '</span>' + '个' + '</p>'
                        + '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                        + '视频巡检事件：' + '<span style="color:#f48225;margin:0 6px;">' + toolTipData.length + '</span>' + '个' + '</p>'
                        + '<p style="color:#fff;font-size:12px;">' + '<i style="display:inline-block;width:10px;height:10px;background:#16d6ff;border-radius:40px;margin:0 8px">' + '</i>'
                        + '智能分析事件：' + '<span style="color:#f4e925;margin:0 6px;">' + toolTipData.length + '</span>' + '个' + '</p>'
                        + '</div>' + '</div>';
                }
                return tipHtml;
            }

        },
        legend: {
            orient: 'vertical',
            y: 'bottom',
            x: 'right',
            data: ['...'],
            textStyle: {
                color: '#fff'
            }
        },
        visualMap: {
            show: false,
            min: 0,
            max: 200,
            left: '10%',
            top: 'bottom',
            calculable: true,
            seriesIndex: [1],
            inRange: {
                color: 'rgba(3, 9, 46, 0.3)',// 蓝绿
            }
        },
        /*工具按钮组*/
        toolbox: {
            show: false,
            orient: 'vertical',
            left: 'right',
            top: 'center',
            feature: {
                dataView: {
                    readOnly: false
                },
                restore: {},
                saveAsImage: {}
            }
        },
        geo: {
            show: true,
            zoom: 1.2,
            map: name,
            label: {
                normal: {
                    textStyle: {
                        color: '#fff'
                    },
                    show: true
                },
                emphasis: {
                    show: true
                }
            },
            roam: true,
            // itemStyle: {
            //     normal: {
            //         areaColor: '#07d8e8',
            //         borderWidth: 2,
            //         shadowColor: 'rgba(1, 71, 189, 1)',
            //         shadowBlur: 100
            //     },
            //     emphasis: {
            //         areaColor: 'rgba(1, 71, 189, 0.3)'
            //     }
            // }
            itemStyle: {
                normal: {
                    borderWidth: 2,
                    areaColor: '#072a69',
                    shadowColor: 'rgba(1, 71, 189, 0.5)',
                    shadowBlur: 100
                },
                emphasis: {
                    areaColor: '#032667'
                }
            }
        },
        series: [{
            name: '散点',
            type: 'scatter',
            coordinateSystem: 'geo',
            data: convertData(data),
            symbolSize: function (val) {
                return val[2] / 10;
            },
            label: {
                normal: {
                    formatter: '{b}',
                    position: 'right',
                    show: true
                },
                emphasis: {
                    show: true
                },
            },
            itemStyle: {
                normal: {
                    color: 'yellow',
                    shadowBlur: 14,
                    shadowColor: 'yellow'
                }
            },
        },
            {
                type: 'map',
                map: name,
                geoIndex: 0,
                aspectScale: 0.75, //长宽比
                showLegendSymbol: false, // 存在legend时显示
                label: {
                    normal: {
                        show: true
                    },
                    emphasis: {
                        show: false,
                        textStyle: {
                            color: '#fff'
                        }
                    }
                },
                roam: true,
                itemStyle: {
                    normal: {
                        areaColor: '#031525',
                        borderColor: '#07d8e8',
                    },
                    emphasis: {
                        areaColor: '#2B91B7'
                    }
                },
                animation: false,
                data: data
            },
            {
                name: '点',
                type: 'scatter',
                coordinateSystem: 'geo',
                zlevel: 6,
            },
            // {
            //     name: 'Top 5',
            //     type: 'effectScatter',
            //     coordinateSystem: 'geo',
            //     data: convertData(data.sort(function (a, b) {
            //         return b.value - a.value;
            //     }).slice(0, 10)),
            //     symbolSize: function (val) {
            //         return val[2] / 10;
            //     },
            //     showEffectOn: 'render',
            //     rippleEffect: {
            //         brushType: 'stroke'
            //     },
            //     hoverAnimation: true,
            //     label: {
            //         normal: {
            //             formatter: '{b}',
            //             position: 'left',
            //             show: false
            //         }
            //     },
            //     itemStyle: {
            //         normal: {
            //             color: 'yellow',
            //             shadowBlur: 14,
            //             shadowColor: 'yellow'
            //         }
            //     },
            //     zlevel: 1
            // },

        ],
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(mapOption, true);

};

//top10

