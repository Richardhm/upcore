<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lembretes</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
  
  
  <!-- Theme style -->
 

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>

     * {margin:0;padding:0;box-sizing: border-box;}
     /* body {height: 100vh;width:100vh;box-sizing: border-box;} */
     .container_total {width:100%;height:100vh;display:flex;flex-direction: column;}
    
     .topo {
        height:40px;
        display: flex; 
        align-items: center;
        justify-content: space-between;
        background-image:linear-gradient(90deg, rgb(0, 29, 54), rgb(12, 101, 168));
        border-bottom: 1px solid white;
    }
    .add_card i {color:white;}
     /* .right {padding-left:40px;} */
     /* .card_container {width:100%;height:100%;overflow:scroll;padding:40px 0;display:grid;grid-template-columns:repeat(3,180px);grid-gap: 40px;} */
     .card_container::-webkit-scrollbar {width:0;}
     .card {width:20%;min-height:100px;max-height:280px;margin:10px;border-radius:11px;padding:8px;display: flex;flex-direction: column;justify-content: space-between;}
     .card_title {width:100%;font-size:14px;font-weight: 500;color:#3a3939;border:none;outline: none;flex-basis: 100%;display: flex;}
     .card_footer {display: flex;justify-content: space-between;}
     .card_edit,.card_delete {height: 23px;width:23px;display: flex;align-items: center;justify-content: center;color:#a8a4a4;background-color: #3a3939;border-radius: 50%;cursor:pointer;}
     .card_delete {
        margin-left:5px;
     }
     .card_theme {border-radius: 50%;height:20px;width:20px;list-style: none;margin:20px auto;cursor:pointer;transform: translateY(calc(var(--i) * -40px));display: none;}
     .card_themes {display: flex;}
     .card_theme {border-radius: 50%;height:20px;width:20px;list-style: none;margin:0 15px;cursor:pointer;display: flex;display: none;}
     #menus {
        width:60%;
        display: flex;
        align-items: center;
     }
     #dashboard {
        width:40%;
        justify-content: flex-end;
        justify-content: end;
        text-align: right;
        display:flex;
        
        
     }

     #dashboard a {
        
        margin:0 7px;
        font-size: 1.2em;;
     }

     #dashboard h4 {
        margin-right: 10px;
     }

     #dashboard a {
        color:#fff;
        text-decoration: none;
     }

     .container {
        height:calc(100vh - 40px);
        display: flex;
        flex-wrap: wrap;
        background-image:linear-gradient(90deg, rgb(0, 29, 54), rgb(12, 101, 168));
     }


     /* .addCard {animation: addCard 0.8s linear;} */
     @keyframes addCard{
        0% {transform:translate(-100%,-100%) scale(0.02);}
        50% {transform:translate(-20%,-70%) scale(0.06);}
        100% {transform:translate(0,0) scale(1);}
     }
     .addCard .card_title {animation: pulse 0.6s 1s both;}
     @keyframes pulse {
        0% {transform:scale(0.9);}
        50% {transform:scale(1.02);}
        100% {transform:scale(1);}
     }
     .card_template {display:flex;align-items:center;justify-content:center;border:2px dashed #056959;}
     .icones {
        display:flex;
     }
  </style>
</head>
<body>
   <div class="container_total">
        
        <div class="topo">
            <div id="menus">
                <span class="add_card">
                    <i class="fas fa-plus-circle" style="font-size:30px;"></i>
                </span>
                <ul class="card_themes">
                    <li class="card_theme" style="--i:1;background-color:#ff9886"></li>
                    <li class="card_theme" style="--i:2;background-color:#ffc664"></li>
                    <li class="card_theme" style="--i:3;background-color:#dda0dd"></li>
                    <li class="card_theme" style="--i:4;background-color:#afeeee"></li>
                    <li class="card_theme" style="--i:5;background-color:#ffd7ba"></li>
                </ul>
            </div>                
            <div id="dashboard">
                <a href="{{route('home.calculadora')}}" class="nav-link text-white">
                    <i class="fas fa-calculator"></i>
                    Calculadora
                </a>
                <a href="{{route('home.calendario')}}" class="nav-link text-white">
                    <i class="fas fa-calendar-alt"></i>
                    Calendario
                </a>
                <a href="{{route('admin.home.search')}}" class="nav-link text-white">
                    <i class="fas fa-money-check-alt"></i>
                    Tabela de Preços
                </a>
                <h4>
                   <a href="{{route('admin.home')}}">Dashboard</a> 
                </h4>
            </div>
        </div>
        
        <div class="container">

        </div>

        
   </div>

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->



<script>
    const addThemebtn = document.querySelector(".add_card");
    const cardThemes = document.querySelector(".card_themes");
    const cardTheme = cardThemes.querySelectorAll(".card_theme");
    const cardCont = document.querySelector(".container");
    var count = 0; 
    var editable = []; 
    let items_db = localStorage.key("items_db") ?  JSON.parse(localStorage.getItem("items_db")) : [];
    if(items_db != undefined && items_db.length >= 1) {
        cardCont.innerHTML = "";
        let ca = "";
        for(let ii=0;ii<items_db.length;ii++) {
            ca = document.createElement('div');
            ca.classList.add('card','addCard');
            ca.innerHTML = `
               
                    <span class="card_title">
                        ${items_db[ii].texto}
                    </span>
                    <span class="card_footer">
                        <div>
                            <small class="card_data">${items_db[ii].data}</small>
                        </div>
                        <div class="icones">     
                            <small class="card_edit" data-id="${ii+1}"><i class="fas fa-pen editar" data-editar="${ii}"></i></small>
                            <small class="card_delete" data-id="${ii+1}"><i class="fas fa-trash deletar" data-deletar="${ii}"></i></small>
                        </div>
                    </span>
                
            `;
            ca.style.backgroundColor = items_db[ii].cor;
            cardCont.prepend(ca);
        }

        document.querySelectorAll(".editar").forEach(function(item){
            item.addEventListener('click',function(e){
                let id = e.target.getAttribute('data-editar');
                let alvo = item.parentElement.closest('.card_footer').previousElementSibling.contentEditable = 'true';
                item.parentElement.innerHTML = '<i class="fas fa-save" id="salve"></i>'               
                document.getElementById("salve").addEventListener('click',function(e){
                    var dados = JSON.parse(localStorage.getItem('items_db'));
                    localStorage.clear('items_db');
                    let text = this.parentElement.closest('.card_footer').previousElementSibling.innerText;
                    dados[id].texto = text;
                    localStorage.setItem("items_db",JSON.stringify(dados));
                    location.reload(true)
                });
            });
        });
    }

     addThemebtn.addEventListener("click",() => {
        if(count % 2 == 0) {
            for(let i=0;i<cardTheme.length;i++) {
                setTimeout(function(){
                    cardTheme[i].style.transform = `translateX(0px)`;
                    cardTheme[i].style.display = `block`;
                },50 * i);
            }
        } else {
            for(let i=0;i<cardTheme.length;i++) {
                setTimeout(function(){
                    cardTheme[cardTheme.length -1 - i].style.transform = `translateX(calc(${cardTheme.length -1 - i} * 40px))`;
                    cardTheme[cardTheme.length -1 - i].style.display = `none`;
                },50 * i);
            }
        }
        count += 1;
     });
     cardTheme.forEach(elem => {
        elem.addEventListener('click',()=>{
            criarCard(elem)
           
        });
     });
     function criarCard(elem) {
            if(document.querySelector('.card_template')) {
                document.querySelector('.card_template').remove();
            }
            let date = new Date();
            let year = date.getFullYear();
            let month = date.getMonth();
            let day = date.getDate();
            let months = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
            let color = elem.style.backgroundColor;
            const card = document.createElement('div');
            card.classList.add('card','addCard');
            card.innerHTML = `
                
                    <span class="card_title">
                        Digite Aqui seu Lembrete
                    </span>
                    <span class="card_footer">
                        <small class="card_data">${months[month]} ${day}, ${year}</small>
                        <small class="card_edit"><i class="fas fa-pen"></i></small>
                    </span>
                
            `;
            card.style.backgroundColor = color;
            cardCont.prepend(card);

            const cards = document.querySelectorAll('.card');

            cards.forEach((card,cardCount)=>{
                editable[cardCount] = false;
                card.querySelector('.card_edit').addEventListener('click',()=>{
                   if(editable[cardCount]) {
                        card.querySelector('.card_title').contentEditable = 'false';
                        editable[cardCount] = false;
                        card.querySelector('.card_edit').innerHTML = '<i class="fas fa-pen"></i>';
                   } else {
                        card.querySelector('.card_title').contentEditable = 'true';
                        editable[cardCount] = true;
                        card.querySelector('.card_edit').innerHTML = '<i class="fas fa-save salvar"></i>';

                        document.querySelector('.salvar').addEventListener('click',function(){
                            addLocal(
                                card.querySelector('.card_title').innerText,
                                card.querySelector('.card_data').innerText,
                                color
                            );
                        });
                    } 
                });
            });
        }

     var a = [];
    
     function addLocal(title,data,cor) {
        if(localStorage.key('items_db')) {
            let b = JSON.parse(localStorage.getItem('items_db'));
            b.push({texto:title,data:data,cor:cor});
            localStorage.setItem("items_db",JSON.stringify(b));
        } else {
            a.push({texto:title,data:data,cor:cor});
            localStorage.setItem("items_db",JSON.stringify(a));
        }
    }

</script>
</body>
</html>