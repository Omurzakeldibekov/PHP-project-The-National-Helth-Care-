
  <?php require_once("partials/head.php");?>
  <?php require_once("partials/reminder.php");?>
  <?php require_once("partials/header.php");?>

  <h2> Description </h2>
  <p> The National Health Centre organizes vaccinations at various times in its central building. This wensite helps you to make an appointment for a covid-19 vaccination. </p> 

  <div class="month">
    <button class="left" name="month">Previous</button>
    <button class="right" name="month">Next</button>
    <h1></h1>
    <form action="book.php" method="post"><table></table></form>
  </div>

  <script>

    let currentMonth = new Date();

    createCalendar(currentMonth);

    let left = document.querySelector(".left");
    left.addEventListener("click", () => {
      currentMonth.setMonth(currentMonth.getMonth() - 1);
      createCalendar(currentMonth)
    });

    let right = document.querySelector(".right");
    right.addEventListener("click", () => {
      currentMonth.setMonth(currentMonth.getMonth() + 1)
      createCalendar(currentMonth);
    });

    async function createCalendar(givenDate){

      let month_list = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

      document.querySelector('h1').innerHTML = month_list[givenDate.getMonth()] + ", " + givenDate.getFullYear();

      let table = document.querySelector('table');
      table.innerHTML = "<tr><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td><td>Sunday</td></tr>";

      let today = givenDate, y = today.getFullYear(), m = today.getMonth();
      let firstDay = new Date(y, m, 1);
      let lastDay = new Date(y, m + 1, 0);

      let rows;
      let week = 1;

      while(firstDay <= lastDay || week % 7 != 1){

        if(week % 7 == 1){
          rows = document.createElement("tr")
        }

        if(firstDay <= lastDay && week > getWeekDay(firstDay)){
          let days = document.createElement("td");

          let h2 = document.createElement("h2");
          h2.innerHTML = firstDay.getDate();
          days.append(h2);

          firstDay.setDate(firstDay.getDate() + 1);

          const result = await fetch(`api/get-date-appointments.php?date=${firstDay.toISOString().split("T")[0]}`);
          const appointments = await result.json();

          console.log(appointments);

          if(result.ok && appointments.length > 0 && <?= (!isset($myAppointment))?("true"):("false") ?>){
            for(let i=0; i<appointments.length; i++){
              let button = document.createElement("button");
              if(appointments[i].people.length < appointments[i].limit){
                button.setAttribute("class", "active");
                button.setAttribute("name", "appointment");
                button.setAttribute("value", appointments[i].id);
                button.innerHTML = `${appointments[i].time} - ${appointments[i].people.length}/${appointments[i].limit}`;
                days.append(button);
              }else{
                button.setAttribute("class", "non_active");
                button.setAttribute("disabled", "true");
                button.innerHTML = `${appointments[i].time} - ${appointments[i].people.length}/${appointments[i].limit}`;
                days.append(button);
              }
            }
          }

          rows.append(days);
        }else{
          rows.append(document.createElement("td"));
        }

        if(week % 7 == 0){
          table.append(rows);
        }

        week++;
      }

      function getWeekDay(date){
        let day = date.getDay();
        if (day == 0) day = 7;
        return day - 1;
      }

    }

  </script>

  <?php require_once("partials/footer.php")?>
