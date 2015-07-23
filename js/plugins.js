jQuery.fn.mailto = function(){
    return this.each(function(){
        var email = $(this).attr("href").replace("(at)", "@").replace("(dot)", ".");;
        $(this).before('<a href="mailto:' + email + '" class="'+$(this).attr("class")+'"  title="Email ' + email + '" id="'+$(this).attr("id")+'">'+$(this).html()+'</a>').remove();
    });
};