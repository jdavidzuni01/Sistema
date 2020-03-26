<footer class="site-footer">
    <div class="footer-inner bg-white">
        <div class="row">
            <div class="col-sm-6">
                Copyright &copy; 2020 MATEMATICA EN TUS MANOS
            </div>
           
        </div>
    </div>
</footer>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta seguro que quiere salirse?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="../index.php?logaut=1" class="btn btn-primary">Salir</a>
            </div>
        </div>
    </div>
</div>


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Scripts -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../assets/js/functions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script src="../assets/js/lib/chosen/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    // Load Resize 

    $(window).load(function () {
        $('#table').dataTable({
            "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página.",
                "zeroRecords": "Lo sentimos. No se encontraron registros.",
                "info": "( Total registros _TOTAL_ )  Página _PAGE_ de _PAGES_ ",
                "infoEmpty": "No hay registros aún.",
                "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                "search": "Buscar: ",
                "LoadingRecords": "Cargando ...",
                "Processing": "Procesando...",
                "SearchPlaceholder": "Comience a teclear...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente",
                }
            },
            "order": [[0, "desc"]],
            //"scrollX": true,
        });
    });


    function showAlerta(tipo, mensage) {

        Command: toastr[tipo](mensage)
            
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

    }

</script> 

<?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1): ?>

<?php endif; ?>


</body>
</html>


