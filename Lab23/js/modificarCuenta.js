  $(function () {
        $("#chkUser").click(function () {
            if ($(this).is(":checked")) {
                $("#dvUsuario").show();
                $("#AddUser").hide();
                
            } else {
                $("#dvUsuario").hide();
                $("#AddUser").show();
            }

             

        });
    });

  $(function () {
        $("#chkContra").click(function () {
            if ($(this).is(":checked")) {
                $("#dvContra").show();
                $("#AddContra").hide();
                
            } else {
                $("#dvContra").hide();
                $("#AddContra").show();
            }

             

        });
	});
	
  $(function () {
        $("#chkRol").click(function () {
            if ($(this).is(":checked")) {
                $("#dvRol").show();
                $("#AddContra").hide();
                
            } else {
                $("#dvRol").hide();
                $("#AddContra").show();
            }

             

        });
    });
