<head>
  <script src="../util/tinymce/js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
        <form method="post" action="../controlador/actualizar.perfil.usuario.controller.php">
            <textarea name="editor" style="width:100%"><?php echo $datosUsuarioBD["perfil_personal"]?></textarea>
            
            <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Guardar Perfil</button>
            </div>
        </form>
</body>

