<div class="container" ng-controller="topicCtrl">
    <div class="block-header">
        <h2>Topics</h2>

        <ul class="actions">
            <li>
                <a href="#">
                    <i class="zmdi zmdi-trending-up"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-check-all"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="#">Refresh</a>
                    </li>
                    <li>
                        <a href="#">Manage Widgets</a>
                    </li>
                    <li>
                        <a href="#">Widgets Settings</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>

    <div class="card">
        <div class="card-header">
            <h2>Basic Table
                <small>Basic example without any additional modification classes</small>
            </h2>
        </div>

        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Source</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="topic in topics">
                        <td>[[topic.id]]</td>
                        <td>[[topic.title]]</td>
                        <td>Christopher</td>
                        <td>@makinton</td>
                        <td>
                            <form action="" method="POST">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE')}}
                                  <button type="button" class="btn btn-icon command-edit waves-effect waves-circle" data-row-id=""><span class="zmdi zmdi-edit"></span></button>
                                <button type="button" class="btn btn-icon command-edit waves-effect waves-circle" data-row-id=""><span class="zmdi zmdi-delete"></span></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
