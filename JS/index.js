window.onscroll = () =>{

    if(window.scrollY > 20){
        document.querySelector('header .header1').classList.add('active')
    }else{
        document.querySelector('header .header1').classList.remove('active')
    }
    
    }
    
    window.onload = () =>{
    
    if(window.scrollY > 20){
        document.querySelector('header .header1').classList.add('active')
    }else{
        document.querySelector('header .header1').classList.remove('active')
    }
    
    }