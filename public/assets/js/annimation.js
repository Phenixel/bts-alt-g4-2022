function annimBack(){
    for(var i = 0; i <= 360 ; i++ ){
        task(i);
    }
    function task(i){
        setTimeout(function() {
            // console.log("et + 1 pour i = " + i)
            $('#body').css("background-image","linear-gradient("+ i +"deg, #a8edea 30%, #fed6e3 100%)");
        }, 800 * i);
    }
}