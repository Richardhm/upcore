@extends('adminlte::page')
@section('title', 'Calendario')

@section('content_top_nav_right')

<li class="nav-item">
        <a href="{{route('home.calculadora')}}" class="nav-link text-white">
            <i class="fas fa-calculator"></i>
            Calculadora
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.calendario')}}" class="nav-link text-white">
            <i class="fas fa-calendar-alt"></i>
            Calendario
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.lembretes')}}" class="nav-link text-white">
            <i class="fas fa-sticky-note"></i>
            Lembretes
        </a>
    </li>
    <li class="nav-item">
        <!-- <div class="d-flex align-items-center bg-danger"> -->
            
            <a href="{{route('admin.home.search')}}" class="nav-link text-white">
                <i class="fas fa-money-check-alt"></i>
                Tabela de Preços
            </a>
        <!-- </div> -->
        
    </li>

@stop



@section('content')

<h1 class="text-white text-center">Calendario</h1>
<div class="d-flex justify-content-center mt-5">
    

    <div class="calendar">
        <div class="calendar-header">
            <span class="month-picker" id="month-picker">Fevereiro</span>
            <span id="today">Hoje</span>
            <div class="year-picker">
                <span class="year-change" id="prev-year">
                    <pre><</pre>
                </span>
                <span id="year">2022</span>
                <span class="year-change" id="next-year">
                    <pre>></pre>
                </span>
            </div>
        </div>
        <div class="calendar-body">
            <div class="calendar-week-day">
                <div>Dom</div>
                <div>Seg</div>
                <div>Ter</div>
                <div>Qua</div>
                <div>Qui</div>
                <div>Sex</div>
                <div>Sab</div>
            </div>
            <div class="calendar-days"></div>
        </div>
        
        <div class="month-list"></div>
    </div>



</div>

@stop

@section('css')
    <style>
        .calendar {height: max-content;width: max-content;background-color: #fdfdfd;border-radius: 30px;padding: 20px;position: relative;overflow: hidden;}
        .light .calendar {box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;}
        .calendar-header {display: flex;justify-content: space-between;align-items: center;font-size: 25px;font-weight: 600;color: #151426;padding: 10px;}  
        .calendar-body {padding: 10px;}
        .calendar-week-day {height: 50px;display: grid;grid-template-columns: repeat(7, 1fr);font-weight: 600;}
        .calendar-week-day div {display: grid;place-items: center;color: #c3c2c8;}
        .calendar-days {display: grid;grid-template-columns: repeat(7, 1fr);gap: 2px;color:#151426;}
        .calendar-days div {width: 50px;height: 50px;display: flex;align-items: center;justify-content: center;padding: 5px;position: relative;cursor: pointer;animation: to-top 1s forwards;}
        .calendar-days div span {position: absolute;}
        .calendar-days div:hover span {transition: width 0.2s ease-in-out, height 0.2s ease-in-out;}
        .calendar-days div span:nth-child(1),
        .calendar-days div span:nth-child(3) {width: 2px;height: 0;background-color:#151426;}
        .calendar-days div:hover span:nth-child(1),
        .calendar-days div:hover span:nth-child(3) {height: 100%;}
        .calendar-days div span:nth-child(1) {bottom: 0;left: 0;}
        .calendar-days div span:nth-child(3) {top: 0;right: 0;}
        .calendar-days div span:nth-child(2),
        .calendar-days div span:nth-child(4) {width: 0;height: 2px;background-color: #151426;}
        .calendar-days div:hover span:nth-child(2),.calendar-days div:hover span:nth-child(4) {width: 100%;}
        .calendar-days div span:nth-child(2) {top: 0;left: 0;}
        .calendar-days div span:nth-child(4) {bottom: 0;right: 0;}
        .calendar-days div:hover span:nth-child(2) {transition-delay: 0.2s;}
        .calendar-days div:hover span:nth-child(3) {transition-delay: 0.4s;}
        .calendar-days div:hover span:nth-child(4) {transition-delay: 0.6s;}
        .calendar-days div.curr-date,.calendar-days div.curr-date:hover {background-color: #0000ff;color: #FFF;border-radius: 50%;}
        .calendar-days div.curr-date span {display: none;}
        .month-picker {padding: 5px 10px;border-radius: 10px;cursor: pointer;}
        .month-picker:hover {background-color: #edf0f5;}
        #year {
            height: 55px;
        }
        .year-picker {display: flex;align-items: center;}
        .year-change {height: 40px;width: 40px;border-radius: 50%;display:flex;align-items:center;cursor: pointer;align-content: center;}
        .year-change pre {
            display: flex;
            background-color: #edf0f5;
            
            align-self: center;
            align-items: center;
            align-content: center;
        }
        .year-change pre:hover {
            font-weight: bold;
        }
        .calendar-footer {padding: 10px;display: flex;justify-content: flex-end;align-items: center;}
        .toggle {display: flex;}
        .toggle span {margin-right: 10px;color:  #151426;}
        .month-list {position: absolute;width: 100%;height: 100%;top: 0;left: 0;background-color: #fdfdfd;padding: 20px;grid-template-columns: repeat(3, auto);gap: 5px;display: grid;transform: scale(1.5);visibility: hidden;pointer-events: none;}
        .month-list.show {transform: scale(1);visibility: visible;pointer-events: visible;transition: all 0.2s ease-in-out;}
        .month-list > div {display: grid;place-items: center;}
        .month-list > div > div {width: 100%;padding: 5px 20px;border-radius: 10px;text-align: center;cursor: pointer;color: #151426;}
        .month-list > div > div:hover {background-color:#edf0f5;}
        @keyframes to-top {
            0% {transform: translateY(100%);opacity: 0;}
            100% {transform: translateY(0);opacity: 1;}
        }
        #today {
            color:#666;
            font-size:0.5em;
            border:1px solid black;
            border-radius:50%;
            padding:5px;
        }
        #today:hover {
            cursor:pointer;
        }
    </style>
@stop



@section('js')
    <script>
        let calendar = document.querySelector('.calendar')
        let today = document.querySelector('#today')
        const month_names = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']

        isLeapYear = (year) => {
            return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
        }

        getFebDays = (year) => {
            return isLeapYear(year) ? 29 : 28
        }

        generateCalendar = (month, year) => {
            
            let calendar_days = calendar.querySelector('.calendar-days')
            let calendar_header_year = calendar.querySelector('#year')

            let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

            calendar_days.innerHTML = ''

            let currDate = new Date()
            if (month ===null || month === undefined) month = currDate.getMonth()
            if (!year) year = currDate.getFullYear()

            let curr_month = `${month_names[month]}`
            month_picker.innerHTML = curr_month
            calendar_header_year.innerHTML = year

            // get first day of month
            
            let first_day = new Date(year, month, 1)

            for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
                let day = document.createElement('div')
                if (i >= first_day.getDay()) {
                    day.classList.add('calendar-day-hover')
                    day.innerHTML = i - first_day.getDay() + 1
                    day.innerHTML += `<span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>`
                    if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                        day.classList.add('curr-date')
                    }
                }
                calendar_days.appendChild(day)
            }
        }

        




        let month_list = calendar.querySelector('.month-list')

        month_names.forEach((e, index) => {
            let month = document.createElement('div')
            month.innerHTML = `<div data-month="${index}">${e}</div>`
            month.querySelector('div').onclick = () => {
                month_list.classList.remove('show')
                curr_month.value = index
                generateCalendar(index, curr_year.value)
            }
            month_list.appendChild(month)
        })

        let month_picker = calendar.querySelector('#month-picker')

        month_picker.onclick = () => {
            month_list.classList.add('show')
        }

        let currDate = new Date()

        let curr_month = {value: currDate.getMonth()}
        let curr_year = {value: currDate.getFullYear()}

        generateCalendar(curr_month.value, curr_year.value)

        document.querySelector('#prev-year').onclick = () => {
            --curr_year.value
            generateCalendar(curr_month.value, curr_year.value)
        }

        document.querySelector('#next-year').onclick = () => {
            ++curr_year.value
            generateCalendar(curr_month.value, curr_year.value)
        }

        today.onclick = () => {
            let todayDate = new Date();
            let curr_month_today = {value: todayDate.getMonth()}
            let curr_year_today = {value: todayDate.getFullYear()}
            generateCalendar(curr_month_today.value,curr_year_today.value);


        }

    </script>
@stop        