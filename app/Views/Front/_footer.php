<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/bootstrap4.6.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/plugins/owlcarousel/owl.carousel.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/light-gallery/lightgallery-all.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/jquery.maskMoney.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/jquery.maskedinput.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/jquery.izoomify.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/common.js?' . date('YmdHis')); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/scripts.js?' . date('YmdHis')); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/outLogin.js?' . date('YmdHis')); ?>"></script>
<script type="text/javascript" src="https://sdk.mercadopago.com/js/v2"></script>
<!--<script type="text/javascript" src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>-->
<script type="text/javascript" src="<?php echo base_url('public/Front/assets/js/mp.js?' . date('YmdHis')); ?>"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<?php if (session()->getFlashdata('erro_pagamento')) : ?>
    <script type="text/javascript">
        $('#pagamentoModal').modal('show');
    </script>
<?php endif; ?>
<?php if (session()->getFlashdata('avaliacao')) : ?>
    <script type="text/javascript">
        $('#avaliacaoModal').modal('show');
    </script>
<?php endif; ?>
<!-- Login  -->
<script>
    function Login() {
        var x = document.getElementById("Login");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
        document.getElementById("LoginForgot").style.display = "none";
        document.getElementById("LoginAcesso").style.display = "none";
        document.getElementById("LoginCode").style.display = "none";

    }

    function LoginClose() {
        document.getElementById("Login").style.display = "none";
    }

    function LoginForgot() {
        document.getElementById("LoginForgot").style.display = "block";
        document.getElementById("LoginAcesso").style.display = "none";
        document.getElementById("LoginCode").style.display = "none";

    }

    function LoginAcesso() {
        document.getElementById("LoginAcesso").style.display = "block";
        document.getElementById("LoginForgot").style.display = "none";
        document.getElementById("LoginCode").style.display = "none";

    }

    function LoginCode() {
        document.getElementById("LoginCode").style.display = "block";
        document.getElementById("LoginForgot").style.display = "none";
        document.getElementById("LoginAcesso").style.display = "none";

    }

    function LoginVoltar() {
        document.getElementById("LoginAcesso").style.display = "none";
        document.getElementById("LoginForgot").style.display = "none";
        document.getElementById("LoginCode").style.display = "none";
    }
</script>

<!-- Atendimento  -->
<script>
    function Atendimento() {
        var x = document.getElementById("Atendimento");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }

    function AtendimentoClose() {
        document.getElementById("Atendimento").style.display = "none";
    }
</script>

<!-- Conta  -->
<script>
    function Conta() {
        var x = document.getElementById("Conta");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }

    function ContaClose() {
        document.getElementById("Conta").style.display = "none";
    }
</script>