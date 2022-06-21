<?php 
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: admin.php");
}
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< DARK LINE <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$query1 = "SELECT  muyene_tarih, count(hayvan_id) as counted FROM muayene_baslik group by muyene_tarih order by muyene_tarih" ;
$qresult = mysqli_query($conn, $query1);
$results1 = array();
$results2 = array();
while ($res = $qresult ->fetch_assoc()){
    $results1[] = $res['muyene_tarih'];
    $results2[] = $res['counted'];
}
mysqli_free_result($qresult);

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< LINE CHART <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$query = "SELECT  hayvan_turu, count(hayvan_id) as counted1 FROM hayvanlar group by hayvan_turu order by hayvan_turu"  ;
$qresult = mysqli_query($conn, $query);
$results3 = array();
$results4 = array();
while ($res = $qresult ->fetch_assoc()){
    $results3[] = $res['hayvan_turu'];
    $results4[] = $res['counted1'];
}
mysqli_free_result($qresult);

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< CIRCLE BAR <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$query = "SELECT  hayvan_turu, count(hayvan_id) as counted_d, cinsiyet FROM hayvanlar group by cinsiyet, hayvan_turu having cinsiyet='D'order by hayvan_turu"  ;
$query4 = "SELECT  hayvan_turu, count(hayvan_id) as counted_e, cinsiyet FROM hayvanlar group by cinsiyet, hayvan_turu having cinsiyet='E'order by hayvan_turu"  ;
$qresult_d = mysqli_query($conn, $query);
$qresult_e = mysqli_query($conn, $query4);
$results5 = array();
$results6 = array();
while ($res_d = $qresult_d ->fetch_assoc() and $res_e = $qresult_e ->fetch_assoc()){
    $results5[] = $res_d['counted_d'];
    $results6[] = $res_e['counted_e'];
}

mysqli_free_result($qresult_d);
mysqli_free_result($qresult_e);

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< KULLANILMADI <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$query = "SELECT
muayene_baslik.muyene_tarih,
SUM(muayene_detay.ucret) AS toplam_odeme
FROM
muayene_baslik
LEFT JOIN muayene_detay ON muayene_detay.muayene_id = muayene_baslik.muayene_id
GROUP BY
muayene_baslik.muyene_tarih
ORDER BY
muayene_baslik.muyene_tarih";
$qresult = mysqli_query($conn, $query);
//$results7 = array();
//$results8 = array();
$data = array();

while ($res = $qresult ->fetch_assoc()){
    //$results7[] = $res;
    $data[] = array((int)$res['toplam_odeme'],  (string)$res['muyene_tarih']);
    $results7[] = (string)$res['muyene_tarih'];
    $results8[] =  $res['toplam_odeme'];
}

mysqli_free_result($qresult);

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< DARK AREA LINE <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$query = "SELECT
CONCAT(
    SUBSTRING(
        veteriner_calisan.calisan_adi,
        1,
        1
    ),
    '. ',
    veteriner_calisan.calisan_soyadi
) AS calisan_adsoyad,
veteriner_calisan.calisan_id,
calisan_ucret
FROM
calisan_odemesi,
veteriner_calisan
WHERE
calisan_odemesi.calisan_id = veteriner_calisan.calisan_id
GROUP BY
veteriner_calisan.calisan_id
ORDER BY
calisan_odemesi.calisan_ucret" ;
$qresult = mysqli_query($conn, $query);
$results9 = array();
$results10 = array();
while ($res = $qresult ->fetch_assoc()){
    $results9[] = (string)$res['calisan_adsoyad'];
    $results10[] = $res['calisan_ucret'];
    
}
mysqli_free_result($qresult);

//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< ROTATABLE BAR <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

$query1 = "SELECT
hayvanlar.hayvan_turu,
servis.servis_turu,
COUNT(hayvanlar.hayvan_id) AS top_muayene
FROM
muayene_baslik,
hayvanlar,
muayene_detay,
servis
WHERE
servis.servis_id = muayene_detay.servis_id AND muayene_baslik.hayvan_id = hayvanlar.hayvan_id AND muayene_detay.muayene_id = muayene_baslik.muayene_id
GROUP BY
muayene_detay.servis_id,
hayvanlar.hayvan_turu
HAVING
hayvanlar.hayvan_turu = 'kedi'
ORDER BY
muayene_detay.servis_id";

$query2 = "SELECT
hayvanlar.hayvan_turu,
servis.servis_turu,
COUNT(hayvanlar.hayvan_id) AS top_muayene
FROM
muayene_baslik,
hayvanlar,
muayene_detay,
servis
WHERE
servis.servis_id = muayene_detay.servis_id AND muayene_baslik.hayvan_id = hayvanlar.hayvan_id AND muayene_detay.muayene_id = muayene_baslik.muayene_id
GROUP BY
muayene_detay.servis_id,
hayvanlar.hayvan_turu
HAVING
hayvanlar.hayvan_turu = 'kopek'
ORDER BY
muayene_detay.servis_id";

$query3 = "SELECT
hayvanlar.hayvan_turu,
servis.servis_turu,
COUNT(hayvanlar.hayvan_id) AS top_muayene
FROM
muayene_baslik,
hayvanlar,
muayene_detay,
servis
WHERE
servis.servis_id = muayene_detay.servis_id AND muayene_baslik.hayvan_id = hayvanlar.hayvan_id AND muayene_detay.muayene_id = muayene_baslik.muayene_id
GROUP BY
muayene_detay.servis_id,
hayvanlar.hayvan_turu
HAVING
hayvanlar.hayvan_turu = 'bukalemun'
ORDER BY
muayene_detay.servis_id";

$qresult1 = mysqli_query($conn, $query1);
$qresult2 = mysqli_query($conn, $query2);
$qresult3 = mysqli_query($conn, $query3);
$results11 = array();
$results12 = array();
$results13 = array();
while ($res1 = $qresult1 ->fetch_assoc() and $res2 = $qresult2 ->fetch_assoc() and $res3 = $qresult3 ->fetch_assoc() ){
    $results11[] = $res1['top_muayene'];
    $results12[] = $res2['top_muayene'];
    $results13[] = $res3['top_muayene'];
    
}
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< GOOGLE PIE <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$query = "SELECT
CONCAT(
    SUBSTRING(
        veteriner_calisan.calisan_adi,
        1,
        1
    ),
    '. ',
    veteriner_calisan.calisan_soyadi
) AS calisan_adsoyad,
COUNT(muayene_id) AS sum_calisan
FROM
muayene_baslik,
veteriner_calisan
WHERE
muayene_baslik.calisan_id = veteriner_calisan.calisan_id
GROUP BY
muayene_baslik.calisan_id
ORDER BY
sum_calisan";
$result_pie = mysqli_query($conn, $query);
?>

<!--************************************************************ HTML *************************************************************-->
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.3.3/dist/echarts.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="style_dashboard.css">
</head>
<body>
    
   <table id="main_tbl">
        <tr>
            <th>  
                <div id="header1" >
                    <?php echo "<h1>HOŞGELDİN " . $_SESSION['username'] . "</h1>"; ?>
                </div>
            </th>
            <th>
                <a href="logout.php">Çıkış Yap</a>
            </th>
           
        </tr>
        <tr>
            <td>
                <table id="chart_tbl">
                    <tr>
                        <td>
                            <div id="container1" style="height: 300px; width: 400px" ></div>
                        </td>
                        <td>
                            <div id="container2" style="height: 300px; width: 400px; background: white;" ></div>
                        </td>
                        <!--<td>
                            <div id="container5" style="height: 300px; width: 400px" ></div>
                        </td>-->
                    
                    </tr>
                    <tr>
                        <td>
                            <div id="container3" style="height: 400px; width: 400px; background: white;" ></div>
                        </td>
                        <td>
                            <div id="container4" style="height: 400px; width: 400px" ></div>
                        </td>
                        <!--
                        <td>
                            <div id="container6" style="height: 400px; width: 400px" ></div>
                        </td>
                        -->
                    </tr>
                </table>
            </td>
           
        </tr>
   </table>
</body>
</html>
<!--**************************************** JAVASCRIPT ****************************************************************************-->
<script type="text/javascript" class="charts">
//------------------------------------------DARK LINE CHART-------------------------------------------------------------------------
    let dom1 = document.getElementById('container1');
    let myChart1 = echarts.init(dom1, 'dark', {
        renderer: 'canvas',
        useDirtyRect: false});
    var app = {};

    var option1;

    option1 = {
        title: {
        text: 'Muayene sayısı'
        },
        xAxis: {
            type: 'category',
            data: <?php echo json_encode($results1);?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: <?php echo json_encode($results2);?>,
                type: 'line'
            }
        ]
        };
    myChart1.setOption(option1);
    window.addEventListener('resize', myChart1.resize);
    
//------------------------------------------BAR CHART---------------------------------------------------------------------------
/*   
    let dom2 = document.getElementById('container2');
    let myChart2 = echarts.init(dom2,  {
        renderer: 'canvas',
        useDirtyRect: false});
    var app = {};

    var option2;

    option2 = {
        xAxis: {
            type: 'category',
            data: < ?php echo json_encode($results5);?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: < ?php echo json_encode($results6);?>,
                type: 'bar'
            }
        ]
        };
    myChart2.setOption(option2);
    window.addEventListener('resize', myChart2.resize);
*/
//-----------------------------------------LINE CHART ---------------------------------------------------------------------------
    let dom3 = document.getElementById('container2');
    let myChart3 = echarts.init(dom3,  {
        renderer: 'canvas',
        useDirtyRect: false});
    var app = {};

    var option3;

    option3 = {
        title: {
        text: 'Türe göre hayvan sayısı'
        },
        xAxis: {
            type: 'category',
            data: <?php echo json_encode($results3);?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: <?php echo json_encode($results4);?>,
                type: 'line'
            }
        ]
    };
    myChart3.setOption(option3);
    window.addEventListener('resize', myChart3.resize);

//----------------------------------DARK AREA LINE CHART------------------------------------------------------------------------------
/*
    let dom5 = document.getElementById('container5');
    let myChart5 = echarts.init(dom5, 'dark', {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option5;

    option5 = {
        title: {
        text: 'Çalışan Maaşı'
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: < ?php echo json_encode($results9);?>
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: < ?php echo json_encode($results10);?>,
                type: 'line',
                areaStyle: {}
            }
        ]
    };
    myChart5.setOption(option5);
    window.addEventListener('resize', myChart5.resize);
*/

//----------------------------------Nightingale Chart(PIE)--------------------------------------------------------------------------------
/*

    let dom4 = document.getElementById('container4');
    let myChart4 = echarts.init(dom4, 'dark',  {
        renderer: 'canvas',
        useDirtyRect: false});
    var app = {};

    var option4;

    option4 = {
        legend: {
            top: 'bottom'
        },
        toolbox: {
            show: true,
            feature: {
            mark: { show: true },
            dataView: { show: true, readOnly: false },
            restore: { show: false },
            saveAsImage: { show: true }
            }
        },
        
        series: [
            {
                name: 'Nightingale Chart',
                type: 'pie',
                radius: [30, 80],
                center: ['40%', '40%'],
                roseType: 'area',
                itemStyle: {
                    borderRadius: 5
                },

                data: 
                    *********< ?php echo json_encode($data);?>
                
            }
        ]
    };

    myChart4.setOption(option4);
    window.addEventListener('resize', myChart4.resize);
   

*/
//---------------------------------------PIE ECHARTS--------------------------------------------------------------------------
/*
    var dom = document.getElementById("container6");
    var myChart = echarts.init(dom, "dark", {
    renderer: "canvas",
    useDirtyRect: false
    });
    var app = {};

    var option;

    option = {
        title: {
            text: "Referer of a Website",
            subtext: "Fake Data",
            left: "center"
        },
        tooltip: {
            trigger: "item"
        },
        legend: {
            orient: "vertical",
            left: "left"
        },
        series: [
            {
            name: "Access From",
            type: "pie",
            radius: "50%",
            data: *********,
            emphasis: {
                itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: "rgba(0, 0, 0, 0.5)"
                }
            }
            
        }]
    };

    
    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }
    window.addEventListener("resize", myChart.resize);
*/
//------------------------------------------------ROTATABLE BAR CHART---------------------------------------------------------------------
var dom = document.getElementById('container4');
    var myChart = echarts.init(dom, 'dark', {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    const posList = [
  'left',
  'right',
  'top',
  'bottom',
  'inside',
  'insideTop',
  'insideLeft',
  'insideRight',
  'insideBottom',
  'insideTopLeft',
  'insideTopRight',
  'insideBottomLeft',
  'insideBottomRight'
];
app.configParameters = {
  rotate: {
    min: -90,
    max: 90
  },
  align: {
    options: {
      left: 'left',
      center: 'center',
      right: 'right'
    }
  },
  verticalAlign: {
    options: {
      top: 'top',
      middle: 'middle',
      bottom: 'bottom'
    }
  },
  position: {
    options: posList.reduce(function (map, pos) {
      map[pos] = pos;
      return map;
    }, {})
  },
  distance: {
    min: 0,
    max: 100
  }
};
app.config = {
  rotate: 90,
  align: 'left',
  verticalAlign: 'middle',
  position: 'insideBottom',
  distance: 15,
  onChange: function () {
    const labelOption = {
      rotate: app.config.rotate,
      align: app.config.align,
      verticalAlign: app.config.verticalAlign,
      position: app.config.position,
      distance: app.config.distance
    };
    myChart.setOption({
      series: [
        {
          label: labelOption
        },
        {
          label: labelOption
        },
        {
          label: labelOption
        },
        {
          label: labelOption
        }
      ]
    });
  }
};
const labelOption = {
  show: true,
  position: app.config.position,
  distance: app.config.distance,
  align: app.config.align,
  verticalAlign: app.config.verticalAlign,
  rotate: app.config.rotate,
  formatter: '{c}  {name|{a}}',
  fontSize: 16,
  rich: {
    name: {}
  }
};
option = {
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  legend: {
    data: ['Kedi', 'Kopek', 'Bukalemun']
  },
  toolbox: {
    show: true,
    orient: 'vertical',
    left: 'right',
    top: 'center',
    feature: {
      mark: { show: true },
      dataView: { show: true, readOnly: false },
      magicType: { show: true, type: ['line', 'bar', 'stack'] },
      restore: { show: true },
      saveAsImage: { show: true }
    }
  },
  xAxis: [
    {
      type: 'category',
      axisTick: { show: false },
      data: ['Cerrahi', 'Dahiliye', 'Ortopedi', 'Dogum']
    }
  ],
  yAxis: [
    {
      type: 'value'
    }
  ],
  series: [
    {
      name: 'Kedi',
      type: 'bar',
      barGap: 0,
      label: labelOption,
      emphasis: {
        focus: 'series'
      },
      data: <?php echo json_encode($results11);?>
    },
    {
      name: 'Kopek',
      type: 'bar',
      label: labelOption,
      emphasis: {
        focus: 'series'
      },
      data:<?php echo json_encode($results12);?>
    },
    {
      name: 'Bukalemun',
      type: 'bar',
      label: labelOption,
      emphasis: {
        focus: 'series'
      },
      data: <?php echo json_encode($results13);?>
    }
 
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
//----------------------------------------------------CIRCLE BAR CHART---------------------------------------------------------------------------

var dom7 = document.getElementById('container3');
    var myChart7 = echarts.init(dom7, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option7;

    option7 = {
        title: {
    text: 'Hayvan Sayısı'
  },
  angleAxis: {},
  radiusAxis: {
    type: 'category',
    data: ['Buk.', 'Kedi', 'Kopek'],
    z: 10
  },
  polar: {},
  series: [
    {
      type: 'bar',
      data: <?php echo json_encode($results5);?>,
      coordinateSystem: 'polar',
      name: 'Disi',
      stack: 'a',
      emphasis: {
        focus: 'series'
      }
    },
    {
      type: 'bar',
      data: <?php echo json_encode($results6);?>,
      coordinateSystem: 'polar',
      name: 'Erkek',
      stack: 'a',
      emphasis: {
        focus: 'series'
      }
    }
    
    
  ],
  legend: {
    show: true,
    data: ['Disi', 'Erkek']
  }
};

    if (option7 && typeof option7 === 'object') {
      myChart7.setOption(option7);
    }

    window.addEventListener('resize', myChart7.resize);

//--------------------------------------------------PIE CHART(GOOGLE)---------------------------------------------------------------------
/*
google.charts.load('current', {'packages':['corechart']});  
google.charts.setOnLoadCallback(drawChart);  
function drawChart()  
{  
    var data8 = google.visualization.arrayToDataTable([  
                ['calisan', 'toplam_is'],  
                <?php  
                while($row = mysqli_fetch_array($result_pie))  
                {  
                    echo "['".$row["calisan_adsoyad"]."', ".$row["sum_calisan"]."],";  
                }  
                ?>  
            ]);  
    var options8 = {  
            title: 'CALISANLARIN CALISMA YUZDESİ',  
            is3D:true,  
            pieHole: 0.4  
            };  
    var chart8 = new google.visualization.PieChart(document.getElementById('container6'));  
    chart8.draw(data8, options8);  
}*/
</script>
