<script>
    $(document).ready(function() {

        $('html').on('input', '#parents-search', (function(event){
            var text = event.target.value;
            // startPreloader();
            $.post(
                '{{ route('frontend.user.parent') }}',
                {
                    id: '{{ $workers['id'] }}',
                    text: text,
                    '_token': '{{ csrf_token() }}'
                },
                function(data) {
                    var searchUp = $('.wrapper-parent-up'),
                        searchDown = $('.wrapper-parent-down'),
                        dataObj = JSON.parse(data),
                        resultUp = dataObj.resultUp,
                        resultDown = dataObj.resultDown;

                    searchUp.empty();
                    searchUp.append(resultUp);

                    searchDown.empty();
                    searchDown.append(resultDown);

                    // stopPreloader();
                }
            );
        }));

        // Убрать начальника

        var buttonDelete = document.querySelector('#remove-parent');
        if (buttonDelete) {
            buttonDelete.addEventListener('click', function(event){
                var select = document.querySelector('#parent_id');

                select.value = '';
            });
        }

    });
</script>