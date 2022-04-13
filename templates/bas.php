</div>

</main>

<script src="js/jquery.min.js" ></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/popper.min.js" ></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-warning").click(function(){
            $(".ligne_commande:first").clone().insertAfter("div.row:first");
        });

    });
</script>


</body>
</html>
