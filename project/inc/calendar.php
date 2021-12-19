<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <link href='../project/fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='../project/fullcalendar/lib/main.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
  </head>
  <body>
    <div id='calendar'>
      <button class = "add-button" type="button" onclick="click_add();" 
      style="border:1px solid gray; border-radius:5px; background-color:white; width:100px; margin:auto; margin-top:30px;">
      <a href="../project/FullCalendar-master/index.html">
      일정추가
    </button>
    </div>
  </body>
</html>

<!-- 

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />


  <title>
    dateClick and selectable dates/times - Demos | FullCalendar
  </title>


<link href='/assets/demo-to-codepen.css' rel='stylesheet' />


  <style>

    html, body {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
      font-size: 14px;
    }

    #calendar {
      max-width: 1100px;
      margin: 40px auto;
    }

  </style>



  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

  

  



<script src='/assets/demo-to-codepen.js'></script>


  <script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      dateClick: function(info) {
        alert('clicked ' + info.dateStr);
      },
      select: function(info) {
        alert('selected ' + info.startStr + ' to ' + info.endStr);
      }
    });

    calendar.render();
  });

</script>

</head>
<body>
  <div class='demo-topbar'>
  <button data-codepen class='codepen-button'>Edit in CodePen</button>

  

  
    Use your mouse or touch device to click/select dates/times
  
</div>

  <div id='calendar'></div>
</body>

</html>

-->