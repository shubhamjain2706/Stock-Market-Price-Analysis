<?php
session_start();
if(isset($_REQUEST['signout'])){
session_destroy();
header("location:login/index.php");
}

if(!$_SESSION['user_type']){
  header("location:login/index.php");
  }
//error_reporting(0);
$year="2015";
$x1="2";
$x2="61";
$company="HCL";
include 'excel_reader.php';
$excel = new PhpExcelReader;
if(isset($_POST['btn'])){
  $_SESSION['company55']=$company=$_POST['company'];
  $x1 = "2";
  $x2= "61";
}
$url='stock price database/closing predicts/2015-CLOSING-PREDICT-'.$company.'.xls';
$excel->read($url);
function sheetData($sheet) {
  $x3=$GLOBALS['x1'];
  $x4=$GLOBALS['x2'];  
   $x = $x3;
    $re="";
 while($x <= $x4) {
    $re .= "";
    $y = 1;
 while($y <= $sheet['numCols']) {
      $cell = $sheet['cells'][$x][5].",";
      $re .= $cell;  
      $y++;
      break;
 }  
    $re .= "";
    $x++;
 }

  return $re .'';     // ends and returns the html table
}
$data=sheetData($excel->sheets[0]); 
$value2=explode(",", $data);
array_pop($value2);
$closing_price = $value2;
//print_r($closing_price);
$cavg=array_sum($closing_price)/30;






function sheetData2($sheet) {
  $x3=$GLOBALS['x1'];
  $x4=$GLOBALS['x2'];  
   $x = $x3;
    $re="";
 while($x <= $x4) {
    $re .= "";
    $y = 1;
 while($y <= $sheet['numCols']) {
      $cell = $sheet['cells'][$x][6].",";
      $re .= $cell;  
      $y++;
      break;
 }  
    $re .= "";
    $x++;
 }

  return $re .'';     // ends and returns the html table
}
$data2=sheetData2($excel->sheets[0]); 
$value3=explode(",", $data2);
array_pop($value3);
$predict_closing = $value3;

$pavg=array_sum($predict_closing)/30;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stock Market Price Analysis</title>
  
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="Decorate/bootstrap/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   
    <link rel="stylesheet" href="Decorate/dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="Decorate/dist/css/skins/_all-skins.min.css">

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
     
     <div>
       <header class="main-header">
      
        <a href="#" class="logo">
         
          <span class="logo-lg"><b>Welcome</b></span>
        </a>
       
        <nav class="navbar navbar-static-top" role="navigation">
         
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              <li class="dropdown messages-menu">
           
              </li>
             
              <li class="dropdown notifications-menu">
             
                <ul class="dropdown-menu">
               
                  <li>
                   
                    <ul class="menu">
                      <li>
                     
                      </li>
                    </ul>
                  </li>
                
                </ul>
              </li>
             
              <li class="dropdown tasks-menu">
             
                <ul class="dropdown-menu">
                
                  <li>
                 
                    <ul class="menu">
                      <li>
                      </li>
                    </ul>
                  </li>
                 
                </ul>
              </li>
            
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                
                  <span class="hidden-xs"><?php echo  ucfirst(strtolower(($_SESSION['user_name']))); ?> <i class="fa fa-gears"></i></span>
                </a>
                <ul class="dropdown-menu">
                  
                  <li class="user-header">

                    <button class="img-circle" style="background-color:#00C0EF; height:80px; width:80px; font-size:24px;" >
                      <?php $name=array(ucwords(strtolower(($_SESSION['user_name']))));
                    echo  $name[0][0]; ?>
                  </button>
                    
                  </li>
                  
                  <li class="user-footer">
                    <div class="pull-left">
                     <a href="transaction.php" class="btn btn-default btn-flat">Transactions</a>
                    </div>
                    <form method="post" action="predict-closing.php">
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat" ><button type="submit" name="signout">Sign out</button></a>
                    </div>
                  </form>
                  </li>
                </ul>
              </li>
             
              <li>
              
              </li>
            </ul>
          </div>
        </nav>
      </header> 
     </div>
     
      <div>
       
        <section class="content">
          <div class="row">
            <div class="col-md-9">
             
                  <div class="box box-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">COMPANY<?php echo "     -".$company; ?></h3>
<span style="color:#00ACD6">______   Predicted Closing Value</span>
<span style="color:#D2D6DE">______   Closing Value</span> <br>
<!-- <span style="red"><?php //echo $pavg."    "; ?>   Predicted Avg Closing Value</span> <br> -->
<!-- <span style="color:blue"><?php //echo $cavg."    "; ?>Avg Closing Value</span>  -->

                     <center><b><h3 class="box-title"><?php echo $year; ?></h3></b></center>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                     <canvas id="lineChart" style="height:200px"></canvas>
                    
                    <div id="chartdiv"></div>  
                  </div>
                </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div><!-- /.col (LEFT) -->
            <div class="col-md-3">
              <!-- LINE CHART -->
              <div class="box box-success">
                 <form method="post" action="predict-closing.php"> 
                    <select class="form-control" style="border-radius:20px"  name="company" required>
                        <option value="">SELECT COMPANY</option>
                        <option value="HCL">HCL</option>
                        <option value="INFOSYS" style="background-color:#D2D6DE">INFOSYS</option>
                        <option value="ORACLE">ORACLE</option>
                        <option value="TCS" style="background-color:#D2D6DE">TCS</option>
                        <option value="WIPRO">WIPRO</option>
                   </select>


               <div class="row" style="margin-top:20px">
                    <div class="col-md-12">

                      <input type="submit" value="GO" name="btn" class="btn btn-block btn-primary">
                    </div>
                  </div>
                 </form>
               <div class="row" style="margin-top:10px">
                    <div class="col-md-12">

                      <a href="monthly-report.php"><input type="button" value="Find By Monthly Report" name="btn" class="btn btn-block btn-info"></a>
                    </div>
                  </div>
                      <div class="row" style="margin-top:10px">
                    <div class="col-md-12">

                      <a href="yearly-report.php"><input type="button" value="Find By Yearly Report" name="btn" class="btn btn-block btn-info"></a>

                    </div>
                  </div>
                  <div class="row" style="margin-top:10px">
                    <div class="col-md-12">

                      <a href="daily-report-all_company.php"><input type="button" value="Find By All Company" name="btn" class="btn btn-block btn-info"></a>
                      <br>
                        <a href="bollingerAlgo.php"><input type="button" value="Find By Bollinger Algo" name="btn" class="btn btn-block btn-success"></a>

                    </div>

                  </div>
                  <div class="row" style="margin-top:40px">
                    <div class="col-md-12">

                   
                    </div>

                  </div>
              </div>
                    </div>
                  </div>   
              </div>
<iframe src="predict-opening.php" width="940px" height="250px" style="margin-top:-50px"></iframe>
                    <canvas id="areaChart" style="height:250px; display:none"></canvas>    
                   
                   

              

            </div>

          </div>

                
        </section>
      </div>
      
    </div>

 
    <script src="Decorate/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    
    <script src="Decorate/bootstrap/js/bootstrap.min.js"></script>
   
    <script src="Decorate/plugins/chartjs/Chart.min.js"></script>
   
    <script src="Decorate/plugins/fastclick/fastclick.min.js"></script>
   
    <script src="Decorate/dist/js/app.min.js"></script>
   
    <script src="Decorate/dist/js/demo.js"></script>
<script>

   
</script>




    <script>
    var data0='<?php echo $closing_price[0]; ?>';
    var data1='<?php echo $closing_price[1]; ?>';
    var data2='<?php echo $closing_price[2]; ?>';
    var data3='<?php echo $closing_price[3]; ?>';
    var data4='<?php echo $closing_price[4]; ?>';
    var data5='<?php echo $closing_price[5]; ?>';
    var data6='<?php echo $closing_price[6]; ?>';
    var data7='<?php echo $closing_price[7]; ?>';
    var data8='<?php echo $closing_price[8]; ?>';
    var data9='<?php echo $closing_price[9]; ?>';
    var data10='<?php echo $closing_price[10]; ?>';
    var data11='<?php echo $closing_price[11]; ?>';
    var data12='<?php echo $closing_price[12]; ?>';
    var data13='<?php echo $closing_price[13]; ?>';
    var data14='<?php echo $closing_price[14]; ?>';
    var data15='<?php echo $closing_price[15]; ?>';
    var data16='<?php echo $closing_price[16]; ?>';
    var data17='<?php echo $closing_price[17]; ?>';
    var data18='<?php echo $closing_price[18]; ?>';
    var data19='<?php echo $closing_price[19]; ?>';
    var data20='<?php echo $closing_price[20]; ?>';
     var data21='<?php echo $closing_price[21]; ?>';
    var data22='<?php echo $closing_price[22]; ?>';
    var data23='<?php echo $closing_price[23]; ?>';
    var data24='<?php echo $closing_price[24]; ?>';
    var data25='<?php echo $closing_price[25]; ?>';
    var data26='<?php echo $closing_price[26]; ?>';
    var data27='<?php echo $closing_price[27]; ?>';
    var data28='<?php echo $closing_price[28]; ?>';
    var data29='<?php echo $closing_price[29]; ?>';
    var data30='<?php echo $closing_price[30]; ?>';


    var data30=[data0,data1,data2,data3,data4,data5,data6,data7,data8,data9,data10,data11,data12,data13,data14,data15,data16,data17,data18,data19,data20,data21,data22,data23,data24,data25,data26,data27,data28,data29,data30,];

var data000='<?php echo $predict_closing[0]; ?>';
var data111='<?php echo $predict_closing[1]; ?>';
var data222='<?php echo $predict_closing[2]; ?>';
var data333='<?php echo $predict_closing[3]; ?>';
var data444='<?php echo $predict_closing[4]; ?>';
var data555='<?php echo $predict_closing[5]; ?>';
var data666='<?php echo $predict_closing[6]; ?>';
var data777='<?php echo $predict_closing[7]; ?>';
var data888='<?php echo $predict_closing[8]; ?>';
var data999='<?php echo $predict_closing[9]; ?>';
var data101010='<?php echo $predict_closing[10]; ?>';
var data111111='<?php echo $predict_closing[11]; ?>';
var data121212='<?php echo $predict_closing[12]; ?>';
var data131313='<?php echo $predict_closing[13]; ?>';
var data141414='<?php echo $predict_closing[14]; ?>';
var data151515='<?php echo $predict_closing[15]; ?>';
var data161616='<?php echo $predict_closing[16]; ?>';
var data171717='<?php echo $predict_closing[17]; ?>';
var data181818='<?php echo $predict_closing[18]; ?>';
var data191919='<?php echo $predict_closing[19]; ?>';
var data202020='<?php echo $predict_closing[20]; ?>';
var data212121='<?php echo $predict_closing[21]; ?>';
var data222222='<?php echo $predict_closing[22]; ?>';
var data232323='<?php echo $predict_closing[23]; ?>';
var data242424='<?php echo $predict_closing[24]; ?>';
var data252525='<?php echo $predict_closing[25]; ?>';
var data262626='<?php echo $predict_closing[26]; ?>';
var data272727='<?php echo $predict_closing[27]; ?>';
var data282828='<?php echo $predict_closing[28]; ?>';
var data292929='<?php echo $predict_closing[29]; ?>';
var data303030='<?php echo $predict_closing[30]; ?>';


    var data60=[data000,data111,data222,data333,data444,data555,data666,data777,data888,data999,data101010,data111111,data121212,data131313,data141414,data151515,data161616,data171717,data181818,data191919,data202020,data212121,data222222,data232323,data242424,data252525,data262626,data272727,data282828,data292929,data303030,]
    



        $(function () {
       
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
       
        var areaChart = new Chart(areaChartCanvas);

        var areaChartData = {
          labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"],
          datasets: [
            {
              label: "Electronics",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: data30
            },
            {
              label: "Digital Goods",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.8)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: data60
            }
          ]
        };

        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: false,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: false,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true
        };

       
        areaChart.Line(areaChartData, areaChartOptions);

 
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        lineChart.Line(areaChartData, lineChartOptions);

       
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
          {
            value: 700,
            color: "#f56954",
            highlight: "#f56954",
            label: "Chrome"
          },
          {
            value: 500,
            color: "#00a65a",
            highlight: "#00a65a",
            label: "IE"
          },
          {
            value: 400,
            color: "#f39c12",
            highlight: "#f39c12",
            label: "FireFox"
          },
          {
            value: 600,
            color: "#00c0ef",
            highlight: "#00c0ef",
            label: "Safari"
          },
          {
            value: 300,
            color: "#3c8dbc",
            highlight: "#3c8dbc",
            label: "Opera"
          },
          {
            value: 100,
            color: "#d2d6de",
            highlight: "#d2d6de",
            label: "Navigator"
          }
        ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
     
        pieChart.Doughnut(PieData, pieOptions);

      
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[1].fillColor = "#00a65a";
        barChartData.datasets[1].strokeColor = "#00a65a";
        barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
      });
    </script>

      </body>
</html>

