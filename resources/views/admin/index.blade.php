

@extends('admin.layouts.master')

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row" style="display: flex;flex-direction:row;justify-content:center">
        <div class="card" style="margin:22px">
            <div class="card-header border-0">
              <h3 class="card-title">Công việc phổ biến theo lĩnh vực</h3>

            </div>
            <div class="card-body table-responsive p-0">


              <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                  <th>Tên</th>
                  <th>Danh Mục</th>
                  <th>Số sượng</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($jobs_total as $job)
                    <tr>
                        <td>
                        {{$job[0]->occupation->name}}
                        </td>
                        <td>
                        {{$job[0]->occupation->category->name}}
                        </td>
                        <td>
                        <small class="text-success mr-1">
                            {{count($job)}}
                        </small>

                        </td>

                    </tr>
                @endforeach

                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card -->
          <div class="card" style="margin:22px">
            <div class="card-header border-0">
              <h3 class="card-title">Số lượng người dùng </h3>

            </div>
            <div class="card-body table-responsive p-0">


              <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                  <th>Người tìm việc</th>
                  <th>Người tuyển dụng</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-primary">
                        {{count($collaborator_total)}}
                        </td>

                        <td class="bg-secondary">
                        {{count($customers)}}

                        </td>
                    </tr>

                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card -->
          <div class="card" style="margin:22px">
            <div class="card-header border-0">
              <h3 class="card-title">Tổng thanh toán đã xác nhận</h3>

            </div>
            <div class="card-body table-responsive p-0">


              <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                  <th>Tổng thanh toán</th>
                  <th>Số lượng công việc</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-primary">
                            {{$profit_sum_of_collaborators}}
                        </td>

                        <td class="bg-secondary">
                            {{$success_job_collaborator_number}}

                        </td>
                    </tr>

                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card -->
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
@endsection
