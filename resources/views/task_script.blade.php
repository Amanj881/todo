<script type="text/javascript">
    $(document).ready(function() {
        $('#addForm').on('submit', function(e) {

            e.preventDefault();
            const url = $(this).attr('action');
            const data = $(this).serialize();
            console.log("Before AJAX Request");

            $.post(url, data, function(response) {
                console.log(response);
                if (response.success) {
                    const appendData = `<tr>
                        <td scope="row"><div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="" id="task_${response?.task?.id}" value="checkedValue">
                            </label>
                        </div></td>
                        <td>${response?.task?.task_name}</td>
                        <td> <i class="fa fa-user-circle" aria-hidden="true"></i></i></td>
                        <td>
                        <form action="/task/destroy/${response?.task?.id}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>

                        </td>
                    </tr>`;
                    $('table tbody').append(appendData);
                } else {

                    if (response.errors) {

                        $.each(response.errors, function(field, errorMessage) {
                            const errorElement =
                                `<label class="error-message text-danger">${errorMessage}</label>`;
                            form.find(`[name="${field}"]`).after(errorElement);
                        });
                    }
                }

            }).fail(function(response) {
                console.log(response.responseJSON);
                (response.status == 422) ? $('.error-message').html(response?.responseJSON
                    ?.message): '';
            })
        })

        $(document).on('click', '.task', function() {
            const id = $(this).attr('data-Id');
            const url = "{!! route('task.update') !!}";
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const checked = $(this).prop('checked');
            const  checked_unChecked =  checked ? 0 : 1 ;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                }
            });
            $.post(url, {
                id: id,'checked':checked_unChecked,
            }, function(res) {
                if (res?.update?.is_completed == 0) {
                    $('#task_' + id).remove();
                }
            })
        })

        $('.show_all').on('click', function() {
            const showAll = $(this).prop('checked') ? 0 : 1;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            const url = "{{ route('task.showAll') }}";

            $.post(url, {
                show_all: showAll
            }, function(res) {
                $("table tbody").empty();


                const appendData = $.each(res?.taskLists, function(index, task) {
                    const isChecked = task.is_completed == 0 ? 'checked' : ''
                    const appendData = `<tr>
                        <td scope="row"><div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input task" type="checkbox" data-Id="${task?.id}" id="task_${task?.id}" value="checkedValue" ${isChecked}>


                            </label>
                        </div></td>
                        <td>${task?.task_name}</td>
                        <td> <i class="fa fa-user-circle" aria-hidden="true"></i></i></td>
                        <td>
                        <form  action="/task/destroy/${task.id}" method="post">
                            @csrf
                             @method('DELETE')
                            <button type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </form>

                        </td>
                    </tr>`;

                    $('table tbody').append(appendData);
                })
            })
        })


        $('.delete').click(function(e) {
            if (!confirm('Are you sure you want to delete this?')) {
                e.preventDefault();
            }
        })

    })
</script>
