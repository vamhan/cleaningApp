
var chartModule = {
  init: function() {
    chartModule.bindDateFilter();
    chartModule.bindChartSelect();
    chartModule.bindPeriodRanking();
    chartModule.bindPeriodDetail();
    chartModule.bindPeriodSelect();
    chartModule.bindDateSelect();
    chartModule.generatePlotChart();
  },

  bindDateFilter: function() {
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     
    var checkin = $('#start_date').datepicker({
      format: 'yyyy-mm-dd',
      onRender: function(date) {
        return date.valueOf() > now.valueOf() ? 'disabled' : '';
        //return "";
      }
    }).on('changeDate', function(ev) {
      var newDate = new Date(ev.date)
      newDate.setDate(newDate.getDate() + 1);
      checkout.setValue(newDate);
      checkin.hide();
      $('#end_date')[0].focus();
    }).data('datepicker');

    var checkout = $('#end_date').datepicker({
      format: 'yyyy-mm-dd',
      onRender: function(date) {
        return date.valueOf() <= checkin.date.valueOf() || date.valueOf() > now.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) {
      checkout.hide();
    }).data('datepicker');
  },

  bindChartSelect: function() {
    $('#chart-picker a').on('click', function(event) {
      event.preventDefault();

      var chart = $(this).attr('href');
      
      $('#chart-picker a').removeClass('active');
      $(this).addClass('active');

      $('#chart').val(chart);

      $('.chart').hide();
      $('#'+chart).show();

      chartModule.generatePlotChart();
    });
  },

  bindPeriodRanking: function() {
    $('.period-btn').on('click', function(event){
        event.preventDefault();

        $('.period-btn').removeClass('active');
        $(this).addClass('active');

        var ranking_url = $('#ranking_url').val();
        var company_id  = $('#company_id').val();
        var period      = $(this).attr('id');

        $.ajax({
            type: 'post',
            url:  ranking_url,
            data: 'company_id='+company_id+'&period='+period+'&ajax=1',
            success: function(data){
              $('#ranking').html(data);
              chartModule.bindPeriodDetail();
            }
        });
    });
  },

  bindPeriodDetail:function() {
    $('.ranking_detail').on('click', function(event) {
        event.preventDefault();

        var ranking_url = $('#ranking_url').val();
        var company_id  = $('#company_id').val();
        var mode        = $(this).data('type');
        var period      = $('.period-btn.active').attr('id');

        $.ajax({
            type: 'post',
            url:  ranking_url,
            data: 'page=detail&limit=20&mode='+mode+'&company_id='+company_id+'&period='+period+'&ajax=1',
            success: function(data){
              $('#ranking-modal .modal-content').html(data);
              $('#ranking-modal').modal();
            }
        });
    });
  },

  bindPeriodSelect: function() {
    $('#period').on('change', function(event) {
        event.preventDefault();

        var period = $(this).val();
        if(period == 'period') {
          $('.period-pick-div').show();
        } else {
          $('.period-pick-div').hide();

          var url         = $('#picker-period').attr('data-url');
          var company_id  = $('#company_id').val();

          $.ajax({
              type: 'post',
              url: url,
              data: 'company_id='+company_id+'&period='+period,
              success: function(data){
                var result = $.parseJSON(data);
                //console.log(result);
                $('#viewer').val(JSON.stringify(result[0]));
                $('#interact').val(JSON.stringify(result[1]));

                chartModule.generatePlotChart();
              }
          }); 
        }
    });    
  },

  bindDateSelect: function() {
    $('#pick-date-btn').on('click', function(event) {
        event.preventDefault();

        var url         = $('#picker-period').attr('data-url');
        //var ranking_url = $('#ranking_url').val();
        var company_id  = $('#company_id').val();
        var period      = $(this).attr('id');

        var start_date  = $('#start_date').val();
        var end_date    = $('#end_date').val();
        period          = start_date+','+end_date;

        $.ajax({
            type: 'post',
            url: url,
            data: 'company_id='+company_id+'&period='+period,
            success: function(data){
              var result = $.parseJSON(data);
              //console.log(result);
              $('#viewer').val(JSON.stringify(result[0]));
              $('#interact').val(JSON.stringify(result[1]));

              chartModule.generatePlotChart();

              /*$.ajax({
                  type: 'post',
                  url:  ranking_url,
                  data: 'company_id='+company_id+'&period='+period+'&ajax=1',
                  success: function(data){
                    $('#ranking').html(data);
                  }
              }); */
            }
        }); 
    });
  },

  generatePlotChart: function() {

    if($('#viewer').length > 0) {

      var chart         = $('#chart').val();
      var viewer_data   = $.parseJSON($('#viewer').val());
      var interact_data = $.parseJSON($('#interact').val());

      var period = $('#period :selected').val();

      var map_month = new Array();
      map_month[1] = 'Jan';
      map_month[2] = 'Feb';
      map_month[3] = 'Mar';
      map_month[4] = 'Apr';
      map_month[5] = 'May';
      map_month[6] = 'Jun';
      map_month[7] = 'Jul';
      map_month[8] = 'Aug';
      map_month[9] = 'Sep';
      map_month[10] = 'Oct';
      map_month[11] = 'Nov';
      map_month[12] = 'Dec';

      if (chart == 'flot-chart') {

        var d2 = [];
        var d3 = [];

        for (var key in viewer_data) {
          if (viewer_data.hasOwnProperty(key)) {
            d2.push([key, viewer_data[key]]);  
          }  
        }

        for (var key in interact_data) {
          if (interact_data.hasOwnProperty(key)) { 
            d3.push([key, interact_data[key]]);  
          }  
        }

        $("#flot-chart").length && $.plot($("#flot-chart"), [{
                data: d2.sort(),
                label: "View Audience"
            }, {
                data: d3.sort(),
                label: "Interactive Audience"
            }], 
            {
              series: {
                  lines: {
                      show: true,
                      lineWidth: 1,
                      fill: true,
                      fillColor: {
                          colors: [{
                              opacity: 0.2
                          }, {
                              opacity: 0.1
                          }]
                      }
                  },
                  points: {
                      show: true
                  },
                  shadowSize: 2
              },
              legend: {
                  show: true,
                  //position: "se",
                  backgroundOpacity: 0.5
              },
              grid: {
                  hoverable: true,
                  clickable: true,
                  tickColor: "#f0f0f0",
                  borderWidth: 0
              },
              colors: ["#C76730","#3090C7"],
              xaxis: {
                  ticks: 31,
                  tickDecimals: 0,
                  tickFormatter: function (val, axis) {
                      var text = val;
                      switch(period){
                      case 'hourly':
                        var this_hr = ("0" + val).slice(-2);
                        var next_hr = parseInt(val)+1;
                        next_hr     = ("0" + next_hr).slice(-2);
                        text        = this_hr + ':00 <br/>-<br/> ' + next_hr + ':00';
                        break;
                      case 'monthly':
                        text = map_month[val];
                        break;
                      }  

                      return text
                  }
              },
              yaxis: {
                  ticks: 15,
                  tickDecimals: 0
              },
              tooltip: true,
              tooltipOpts: {
                content: "'%s' of %x.1 is %y.4",
                defaultTheme: false,
                shifts: {
                  x: 0,
                  y: 20
                }
              }
            }
        );
      } else if (chart == 'flot-pie') {

        var pie_viewer_data = [];
        var i  = 0;
        for (var key in viewer_data) {
          if (viewer_data.hasOwnProperty(key)) {
            pie_viewer_data[i] = {
              label: key,
              data: viewer_data[key]
            }
            i++;
          }  
        }  

        $("#flot-pie-viewer").length && $.plot($("#flot-pie-viewer"), pie_viewer_data, {
          series: {
            pie: {
              combine: {
                color: "#999"
              },
              show: true,
              label: {
                  show: true,
                  formatter: function (label, series) {
                      var text = label;
                      
                      switch(period){
                      case 'hourly':
                        var this_hr = ("0" + label).slice(-2);
                        var next_hr = parseInt(label)+1;
                        next_hr     = ("0" + next_hr).slice(-2);
                        text        = this_hr + ':00 - ' + next_hr + ':00';
                        break;
                      case 'monthly':
                        text = map_month[label];
                        break;
                      } 

                      return '<div style="font-size:8pt;text-align:center;padding:2px;color:black;">' + text +'<br/>' + series.data[0][1] + ' people</div>';
                  }
              }
            }
          },    
          colors: ["#b6b6b4","#d1d0ce","#e5e4e2","#bcc6cc","#98afc7","#6d7b8d","#737ca1","#4863a0","#2b547e","#2b3856","#151b54","#342d7e","#15317e","#0020c2","#2554c7","#1569c7","#1f45fc","#6960ec","#357ec7","#488ac7","#3090c7","#659ec7","#87afc7","#95b9c7","#728fce","#2b65ec","#306eff","#1589ff","#6495ed","#6698ff","#56a5ec"],
          legend: {
            show: false
          },
          grid: {
            hoverable: true,
            clickable: false
          },
          tooltip: true,
          tooltipOpts: {
            content: "%p.0%",
            defaultTheme: false,
            shifts: {
              x: 0,
              y: 20
            }
          }
        });

        var pie_interact_data = [];
        var i  = 0;
        for (var key in interact_data) {
          if (interact_data.hasOwnProperty(key)) {
            pie_interact_data[i] = {
              label: key,
              data: interact_data[key]
            }
            i++;
          }  
        }

        $("#flot-pie-interact").length && $.plot($("#flot-pie-interact"), pie_interact_data, {
          series: {
            pie: {
              combine: {
                color: "#999"
              },
              show: true,
              label: {
                  show: true,
                  formatter: function (label, series) {
                      var text = label;
                      
                      switch(period){
                      case 'hourly':
                        var this_hr = ("0" + label).slice(-2);
                        var next_hr = parseInt(label)+1;
                        next_hr     = ("0" + next_hr).slice(-2);
                        text        = this_hr + ':00 - ' + next_hr + ':00';
                        break;
                      case 'monthly':
                        text = map_month[label];
                        break;
                      } 

                      return '<div style="font-size:8pt;text-align:center;padding:2px;color:black;">' + text +'<br/>' + series.data[0][1] + ' people</div>';
                  }
              }
            }
          },    
          colors: ["#4cc552","#54c571","#99c68e","#89c35c","#85cc65","#8bb381","#9cb071","#b2c248","#9dc209","#a1c935","#57e964","#64e986","#5efb6e","#5ffc17","#87f717","#6afb92","#98ff98","#b5eaaa","#c3fd88","#ccfb5d","#b1fb17","#bce954","#59e817","#52d017","#4cc417","#6cc417","#3ea055","#4aa02c","#6aa121","#4e9258","#347c17"],
          legend: {
            show: false
          },
          grid: {
            hoverable: true,
            clickable: false
          },
          tooltip: true,
          tooltipOpts: {
            content: "%p.0%",
            defaultTheme: false,
            shifts: {
              x: 0,
              y: 20
            }
          }
        });    
      } else if (chart == 'flot-bar') {

        var viewer_bar_data = [];
        for (var key in viewer_data) {
          if (viewer_data.hasOwnProperty(key)) {
            viewer_bar_data.push([key, viewer_data[key]]);  
          }  
        }

        var interact_bar_data = [];
        for (var key in interact_data) {
          if (interact_data.hasOwnProperty(key)) {
            interact_bar_data.push([key, interact_data[key]]);  
          }  
        }

        var bar_data = [
          {
              label: "View Audience",
              data: viewer_bar_data,
              bars: {
                  show: true,
                  fill: true,
                  order: 1,
                  fillColor:  "#6783b7"
              },
              color: "#6783b7"
          },
          {
              label: "Interact Audience",
              data: interact_bar_data,
              bars: {
                  show: true,
                  fill: true,
                  order: 2,
                  fillColor:  "#4fcdb7"
              },
              color: "#4fcdb7"
          }
        ];        

        var margin = 0;
        if(period == 'yearly') {
          margin = .30;
        }

        $("#flot-bar").length && $.plot($("#flot-bar"), bar_data, {
            xaxis: {
              ticks: viewer_bar_data.length,
              tickFormatter: function (val, axis) {
                  var text = val;

                  switch(period){
                  case 'hourly':
                    var this_hr = ("0" + val).slice(-2);
                    var next_hr = parseInt(val)+1;
                    next_hr     = ("0" + next_hr).slice(-2);
                    text        = this_hr + ':00 <br/>-<br/> ' + next_hr + ':00';
                    break;
                  case 'monthly':
                    text = map_month[val];
                    break;
                  }  

                  return text
              },
              autoscaleMargin: margin // allow space left and right
            },
            yaxis: {
                
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 0
            },
            legend: {
                labelBoxBorderColor: "none",
                position: "left"
            },
            valueLabels: {
                show: true
            },
            series: {
                bars: {
                    show: true,        
                    barWidth: 0.3,
                    fill: true,
                    lineWidth: 1
                }
            },
            tooltip: false
        });
      } 
    }
  }
}