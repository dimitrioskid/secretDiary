        <script>
            //Sign up, Log in button
            $(".toggleForms").click(function(){
               
               $("#signUpForm").toggle();
               $("#logInForm").toggle();
            });

            //Detecting any updates and sending to updatedb.php
            $("#diary").bind('input propertychange', function(){

                $.ajax({
                    method: "POST",
                    url: "updatedb.php",
                    data: {content: $("#diary").val()}
                });                
            });

            //Tooltips enable
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        </script>
    </body>
</html>