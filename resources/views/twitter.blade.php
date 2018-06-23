<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5 - Twitter API</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


<div class="container">
    <h2>Laravel 5 - Twitter API</h2>
    <form method="POST" action="{{route('twitter.timeline')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label>Enter UserName:</label>
            <input type="text" name="name" class="form-control"/>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Go</button>
        </div>

    </form>

{{--
    <form method="POST" action="{{ route('post.tweet') }}" enctype="multipart/form-data">


        {{ csrf_field() }}


        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label>Add Tweet Text:</label>
            <textarea class="form-control" name="tweet"></textarea>
        </div>
        <div class="form-group">
            <label>Add Multiple Images:</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Add New Tweet</button>
        </div>
    </form>--}}
    <form method="POST" action="{{ route('search.tweet') }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label>Search Tweet:</label>
            <input type="text" class="form-control" name="search"/>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Search</button>
        </div>
    </form>

    <form method="POST" action="retweet">
        <label>Retweet Message:</label>
        <input type="text" class="form-control" name="message">


    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="50px">No</th>
            <th>Twitter Id</th>
            <th>Message</th>
            <th>Images</th>
            <th>Favorite</th>
            <th>Retweet Count</th>
            <th>Retweet</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))


                {{csrf_field()}}

            @foreach($data as $key => $value)
                <?php if (!isset($value['id']) || !isset($value['text']) || !isset($value['favorite_count']) || !isset($value['retweet_count'])){

                }
                else{
                ?>

                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $value['id'] }}</td>
                    <td>{{ $value['text'] }}</td>
                    <td>
                        @if(!empty($value['extended_entities']['media']))
                            @foreach($value['extended_entities']['media'] as $v)
                                <img src="{{ $v['media_url_https'] }}" style="width:100px;">
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $value['favorite_count'] }}</td>
                    <td>{{ $value['retweet_count'] }}</td>
                    <td><button name="tweetid" value="{{$value['id']}}">Retweet</button></td>
                </tr>
        </tbody>
                <?php } ?>

            </form>
            @endforeach
        @else
            <tr>
                <td colspan="6">There are no data.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>


</body>
</html>