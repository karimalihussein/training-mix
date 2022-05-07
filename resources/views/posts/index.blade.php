
                  <table class="table table-striped">
                    @foreach ($posts as $post) 
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->active }}</td>
                            </tr>
                    @endforeach
                </table>

