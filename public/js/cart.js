<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
$(document).ready(function(){
    // Bắt sự kiện khi nút được nhấn
    $('.btnup').click(function(){
        var itemId = $(this).data('id');
        console.log(itemId);
        upQuality(itemId); 
    });

    function upQuality(id){ 
        $.ajax({
            type: "post",
            url: "/chieu2/cart/upQuality/"+id,
            success: function (response) {
                location.reload();
            }
        });
    }

    $('.btndown').click(function(){
        var itemId = $(this).data('id');
        console.log(itemId);
        downQuantity(itemId); 
    });

    function downQuantity(id){ 
        $.ajax({
            type: "post",
            url: "/chieu2/cart/downQuality/"+id,
            success: function (response) {
                location.reload();
            }
        });
    }
   
    $('.btndelete').click(function(){
        var itemId = $(this).data('id');
        console.log(itemId);
        deleteP(itemId);
    });
    function deleteP(id){ 
        $.ajax({
            type: "post",
            url: "/chieu2/cart/delete/"+id,
            success: function (response) {
                location.reload();
            }
        });
    }
    
    $("#btnthanhtoan").click(function (e) { 
    e.preventDefault();
    window.location.href = "/chieu2/user/checkout";
});

});
