<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        //select 2
        $('.select2').select2({
            placeholder: 'Select Difficulty Levels',
            allowClear: true,
            tags: true,
            theme: 'classic',
            matcher: function(params, data) {
                // Hide selected options
                if ($.inArray(data.id, $('.select2').val()) !== -1) {
                    return null;
                }

                // Filter for non-selected options
                if ($.trim(params.term) === '') {
                    return data;
                }

                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                    return data;
                }

                return null;
            }
        });
        //select 3
        $('.select3').select2({
            placeholder: 'Select Skills',
            allowClear: true,
            tags: true,
            theme: 'classic',
            matcher: function(params, data) {
                // Hide selected options
                if ($.inArray(data.id, $('.select3').val()) !== -1) {
                    return null;
                }

                // Filter for non-selected options
                if ($.trim(params.term) === '') {
                    return data;
                }

                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                    return data;
                }

                return null;
            }
        });
    });
</script>