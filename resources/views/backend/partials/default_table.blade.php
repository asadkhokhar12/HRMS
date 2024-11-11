<div class="table-content table-basic">
    <div class="">
      <div class="card-header">{{ _trans('partial.Basic Datatable') }}</div>
        <!-- toolbar table start -->
        <div
          class="table-toolbar d-flex flex-wrap gap-2 flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
          <div class="align-self-center">
            <div
              class="d-flex flex-wrap gap-2  flex-lg-row justify-content-center align-content-center">
              <!-- show per page -->
              <div class="align-self-center">
                <label>
                  <span class="mr-8">{{ _trans('partial.Show') }}</span>
                  <select class="form-select d-inline-block">
                    <option value="10">{{ _trans('partial.10') }}</option>
                    <option value="25">{{ _trans('partial.25') }}</option>
                    <option value="50">{{ _trans('partial.50') }}</option>
                    <option value="100">{{ _trans('partial.100') }}</option>
                  </select>
                  <span class="ml-8">{{ _trans('partial.Entries') }}</span>
                </label>
              </div>

              <div class="align-self-center d-flex flex-wrap gap-2">
                <!-- add btn -->
                <div class="align-self-center">
                  <a href="#" role="button" class="btn-add" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="{{ _trans('common.Add') }}">
                    <span><i class="fa-solid fa-plus"></i> </span>
                    <span class="d-none d-xl-inline">{{ _trans('partial.Add') }}</span>
                  </a>
                </div>
                <!-- daterange -->
                <div class="align-self-center">
                  <button type="button" class="btn-daterange" id="daterange" data-bs-toggle="tooltip"
                    data-bs-placement="right" data-bs-title="{{ _trans('common.Date Range') }}">
                    <span class="icon"><i class="fa-solid fa-calendar-days"></i>
                    </span>
                    <span class="d-none d-xl-inline">{{ _trans('partial.Date Range') }}</span>
                  </button>
                </div>
                <!-- Designation -->
                <div class="align-self-center">
                  <div class="dropdown dropdown-designation" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="{{ _trans('common.Designation') }}">
                    <button type="button" class="btn-designation" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="icon"><i class="fa-solid fa-user-shield"></i></span>

                      <span class="d-none d-xl-inline">{{ _trans('partial.Designation') }}</span>
                    </button>

                    <div class="dropdown-menu">
                      <div class="search-content">
                        <div class="search-box d-flex">
                          <input class="form-control" placeholder="{{ _trans('common.Search') }}" name="search" />
                          <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                        </div>
                      </div>

                      <div class="dropdown-divider"></div>

                      <ul class="list">
                        <li class="list-item">
                          <a class="dropdown-item" href="#">{{ _trans('partial.Main Department') }}</a>
                        </li>

                        <li class="list-item">
                          <a class="dropdown-item" href="#">{{ _trans('partial.Admin & HRM') }}</a>
                        </li>

                        <li class="list-item">
                          <a class="dropdown-item" href="#">{{ _trans('partial.Accounts') }}</a>
                        </li>

                        <li class="list-item">
                          <a class="dropdown-item" href="#">{{ _trans('partial.Development') }}</a>
                        </li>

                        <li class="list-item">
                          <a class="dropdown-item" href="#">{{ _trans('partial.Software') }}</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <!-- search -->
              <div class="align-self-center">
                <div class="search-box d-flex">
                  <input class="form-control" placeholder="{{ _trans('common.Search') }}" name="search" />
                  <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                </div>
              </div>

              <!-- dropdown action -->
              <div class="align-self-center">
                <div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="right"
                  data-bs-title="{{ _trans('common.Action') }}">
                  <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#"><span class="icon mr-10"><i
                            class="fa-solid fa-eye"></i></span>
                        {{ _trans('partial.Make Publish') }}</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" aria-current="true"><span class="icon mr-8"><i
                            class="fa-solid fa-eye-slash"></i></span>
                        {{ _trans('partial.Make Unpublish') }}</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>{{ _trans('partial.Delete') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- export -->
          <div class="align-self-center">
            <div class="d-flex justify-content-center justify-content-xl-end align-content-center">
              <div class="dropdown dropdown-export" data-bs-toggle="tooltip" data-bs-placement="right"
                data-bs-title="{{ _trans('common.Export') }}">
                <button type="button" class="btn-export" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>

                  <span class="d-none d-xl-inline">{{ _trans('partial.Export') }}</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#"><span class="icon mr-8"><i
                          class="fa-solid fa-copy"></i></span>
                      {{ _trans('partial.Copy') }}</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#" aria-current="true"><span class="icon mr-10"><i
                          class="fa-solid fa-file-excel"></i></span>
                      {{ _trans('partial.Exel File') }}</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="icon mr-14"><i class="fa-solid fa-file-csv"></i></span>{{ _trans('partial.Csv File') }}
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="icon mr-14"><i class="fa-solid fa-file-pdf"></i></span>{{ _trans('partial.Pdf File') }}
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="icon mr-10"><i class="fa-solid fa-table-columns"></i></span>{{ _trans('partial.Column Header') }}
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- toolbar table end -->
        <!--  table start -->
        <div class="table-responsive  min-height-500">
          <table class="table table-bordered">
            <thead class="thead">
              <tr>
                <th class="sorting_asc">
                  <div class="check-box">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" />
                    </div>
                  </div>
                </th>
                <th class="sorting_desc">{{ _trans('partial.SR No.') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Purchase ID') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Title') }}</th>
                <th class="sorting_desc">{{ _trans('partial.User') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Assigned To') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Created By') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Create Date') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Status') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Priority') }}</th>
                <th class="sorting_desc">{{ _trans('partial.Action') }}</th>
              </tr>
            </thead>
            <tbody class="tbody">
              <tr>
                <td>
                  <div class="check-box">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" />
                    </div>
                  </div>
                </td>
                <td>{{ _trans('partial.01') }}</td>
                <td>{{ _trans('partial.IDL-963') }}</td>
                <td>{{ _trans('partial.Add Dynamic Contact List') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Peter Parker') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Jan 14, 2022') }}</td>
                <td>
                  <span class="badge-light-success">{{ _trans('partial.Re-open') }}</span>
                </td>
                <td>
                  <span class="badge-success">{{ _trans('partial.High') }}</span>
                </td>
                <td>
                  <div class="dropdown dropdown-action">
                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="#"><span class="icon mr-12"><i
                              class="fa-solid fa-pen-to-square"></i></span>
                          {{ _trans('partial.Edit') }}</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>{{ _trans('partial.Delete') }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="check-box">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" />
                    </div>
                  </div>
                </td>
                <td>{{ _trans('partial.01') }}</td>
                <td>{{ _trans('partial.IDL-963') }}</td>
                <td>{{ _trans('partial.Add Dynamic Contact List') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Peter Parker') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Jan 14, 2022') }}</td>
                <td>
                  <span class="badge-light-danger">{{ _trans('partial.Re-open') }}</span>
                </td>
                <td>
                  <span class="badge-danger">{{ _trans('partial.High') }}</span>
                </td>
                <td>
                  <div class="dropdown dropdown-action">
                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="#"><span class="icon mr-12"><i
                              class="fa-solid fa-pen-to-square"></i></span>
                          {{ _trans('partial.Edit') }}</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>{{ _trans('partial.Delete') }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="check-box">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" />
                    </div>
                  </div>
                </td>
                <td>{{ _trans('partial.01') }}</td>
                <td>{{ _trans('partial.IDL-963') }}</td>
                <td>{{ _trans('partial.Add Dynamic Contact List') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Peter Parker') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Jan 14, 2022') }}</td>
                <td>
                  <span class="badge-light-warning">{{ _trans('partial.Re-open') }}</span>
                </td>
                <td>
                  <span class="badge-warning">{{ _trans('partial.High') }}</span>
                </td>
                <td>
                  <div class="dropdown dropdown-action">
                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="#"><span class="icon mr-12"><i
                              class="fa-solid fa-pen-to-square"></i></span>
                          {{ _trans('partial.Edit') }}</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>{{ _trans('partial.Delete') }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="check-box">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" />
                    </div>
                  </div>
                </td>
                <td>{{ _trans('partial.01') }}</td>
                <td>{{ _trans('partial.IDL-963') }}</td>
                <td>{{ _trans('partial.Add Dynamic Contact List') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Peter Parker') }}</td>
                <td>{{ _trans('partial.Robert Downey') }}</td>
                <td>{{ _trans('partial.Jan 14, 2022') }}</td>
                <td>
                  <span class="badge-light-primary">{{ _trans('partial.Re-open') }}</span>
                </td>
                <td>
                  <span class="badge-primary">{{ _trans('partial.High') }}</span>
                </td>
                <td>
                  <div class="dropdown dropdown-action">
                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="#"><span class="icon mr-12"><i
                              class="fa-solid fa-pen-to-square"></i></span>
                          {{ _trans('partial.Edit') }}</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <span class="icon mr-16"><i class="fa-solid fa-trash-can"></i></span>{{ _trans('partial.Delete') }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--  table end -->
        <!--  pagination start -->
        <div class="ot-pagination d-flex justify-content-end align-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link active" href="#">{{ _trans('partial.1') }}</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">{{ _trans('partial.2') }}</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">{{ _trans('partial.3') }}</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                </a>
              </li>
            </ul>
          </nav>
        </div>

        <!--  pagination end -->
      </div>
</div>