$(document).ready(function() {
    $('#example').DataTable();
} );

function getStocks(){
    $.ajax({url:"https://ph.investing.com/stock-screener/Service/SearchStocks",
        success:function(result) {
            console.log(result);
        },
        dataType:"jsonp",
        type:"POST",
        crossDomain:true,
    })
}