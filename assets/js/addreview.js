 
$('#addreview').click(function(){
    $.ajax({
        type:'POST',
        url:'".SITE_URL."/itineraries/getReviewForm',
        dataType:'json',
        cache:'false',
        data:{
            pid:'".$details->trip_id."',
        },
        beforeSend:function(){
            $('tab-content').html('<img src = >');
        },
        success:function(){
            
        },
    });                
});
