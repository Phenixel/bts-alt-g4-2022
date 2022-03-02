function annimBack(){
    for(var i = 0; i <= 1440 ; i++ ){
        task(i);
    }
    function task(i){
        setTimeout(function() {
            // console.log("et + 1 pour i = " + i)
            $('#body').css("background-image","linear-gradient("+ i +"deg, #a8edea 30%, #fed6e3 100%)");
        }, 400 * i);
    }
}

function passToDarkMode(){

    if($("#table").hasClass("table-dark"))
    {
        $(".table").removeClass('table-dark');
        $("#passDark").removeClass('fa-sun').addClass("fa-moon");
        $(".icon_index").removeClass("icon_index_dark");
    }
    else
    {
        $(".table").addClass('table-dark');
        $("#passDark").addClass('fa-sun').removeClass("fa-moon");
        $(".icon_index").addClass("icon_index_dark");
    }

}