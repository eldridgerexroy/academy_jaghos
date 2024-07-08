<?php $__env->startPush('libraries_top'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-header">
        <h1><?php echo e(trans('admin/main.affiliate_users')); ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?php echo e(getAdminPanelUrl()); ?>"><?php echo e(trans('admin/main.dashboard')); ?></a></div>
            <div class="breadcrumb-item"><?php echo e(trans('admin/main.affiliate_users')); ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_referrals_export')): ?>
                        <div class="text-right">
                            <a href="<?php echo e(getAdminPanelUrl()); ?>/referrals/excel?type=users" class="btn btn-primary"><?php echo e(trans('admin/main.export_xls')); ?></a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <form id="filters-form" action="<?php echo e(url()->current()); ?>" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="filter-container">
                                        <label for="month">Select Month:</label>
                                        <select id="month" name="month" class="form-control my-2">
                                            <option value="0" <?php echo e($selectedMonth == "0" ? 'selected' : ''); ?>>All Months</option>
                                            <option value="1" <?php echo e($selectedMonth == "1" ? 'selected' : ''); ?>>January</option>
                                            <option value="2" <?php echo e($selectedMonth == "2" ? 'selected' : ''); ?>>February</option>
                                            <option value="3" <?php echo e($selectedMonth == "3" ? 'selected' : ''); ?>>March</option>
                                            <option value="4" <?php echo e($selectedMonth == "4" ? 'selected' : ''); ?>>April</option>
                                            <option value="5" <?php echo e($selectedMonth == "5" ? 'selected' : ''); ?>>May</option>
                                            <option value="6" <?php echo e($selectedMonth == "6" ? 'selected' : ''); ?>>June</option>
                                            <option value="7" <?php echo e($selectedMonth == "7" ? 'selected' : ''); ?>>July</option>
                                            <option value="8" <?php echo e($selectedMonth == "8" ? 'selected' : ''); ?>>August</option>
                                            <option value="9" <?php echo e($selectedMonth == "9" ? 'selected' : ''); ?>>September</option>
                                            <option value="10" <?php echo e($selectedMonth == "10" ? 'selected' : ''); ?>>October</option>
                                            <option value="11" <?php echo e($selectedMonth == "11" ? 'selected' : ''); ?>>November</option>
                                            <option value="12" <?php echo e($selectedMonth == "12" ? 'selected' : ''); ?>>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="filter-container">
                                        <label for="year">Select Year:</label>
                                        <select id="year" name="year" class="form-control my-2">
                                            <option value="0" <?php echo e($selectedYear == "0" ? 'selected' : ''); ?>>All Years</option>
                                            <option value="2024" <?php echo e($selectedYear == "2024" ? 'selected' : ''); ?>>2024</option>
                                            <option value="2025" <?php echo e($selectedYear == "2025" ? 'selected' : ''); ?>>2025</option>
                                            <!-- Add more years if needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div id="affiliates-table" class="table-responsive mt-3">
                            <table class="table table-striped font-14">
                                <thead>
                                    <tr>
                                        <th><?php echo e(trans('admin/main.user')); ?></th>
                                        <th><?php echo e(trans('admin/main.role')); ?></th>
                                        <th><?php echo e(trans('admin/main.referral_code')); ?></th>
                                        <th><?php echo e(trans('admin/main.aff_sales_commission')); ?></th>
                                        <!-- <th><?php echo e(trans('admin/main.status')); ?></th> -->
                                        <th><?php echo e(trans('admin/main.paid_status')); ?></th>
                                        <th><?php echo e(trans('admin/main.paid_date')); ?></th>
                                        <th><?php echo e(trans('admin/main.actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $affiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($affiliate->affiliateUser->full_name); ?></td>
                                        <td>
                                            <?php if($affiliate->affiliateUser->isUser()): ?>
                                            Student
                                            <?php elseif($affiliate->affiliateUser->isTeacher()): ?>
                                            Teacher
                                            <?php elseif($affiliate->affiliateUser->isOrganization()): ?>
                                            Organization
                                            <?php elseif($affiliate->affiliateUser->isSponsorAffiliate()): ?>
                                            Sponsor 
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(!empty($affiliate->affiliateUser->getUserGroup()) ? $affiliate->affiliateUser->getUserGroup()->name : '-'); ?></td>
                                        <td><b><?php echo e(handlePrice($affiliate->amount)); ?></b></td>
                                        <!-- <td><?php echo e($affiliate->affiliateUser->affiliate ? trans('admin/main.yes') : trans('admin/main.no')); ?></td> -->
                                        <td>
                                            <?php if($affiliate->paid_status): ?>
                                                <span class="badge badge-success">Paid</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="view-details" 
                                                    data-toggle="modal" 
                                                    data-target="#affiliateDetailModal"
                                                    data-details='<?php echo json_encode($affiliate->affiliateDetail, 15, 512) ?>'
                                                    data-username="<?php echo e($affiliate->affiliateUser->full_name); ?>"
                                                    style="border:0px; background-color:white">
                                                    
                                                <span class="badge badge-primary">View Details</span>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(getAdminPanelUrl()); ?>/users/<?php echo e($affiliate->affiliateUser->id); ?>/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('admin/main.edit')); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="card">
    <div class="card-body">
        <div class="section-title ml-0 mt-0 mb-3">
            <h5><?php echo e(trans('admin/main.hints')); ?></h5>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="media-body">
                    <div class="text-primary mt-0 mb-1 font-weight-bold"><?php echo e(trans('admin/main.registration_income_hint')); ?></div>
                    <div class="text-small font-600-bold"><?php echo e(trans('admin/main.registration_income_desc')); ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="media-body">
                    <div class="text-primary mt-0 mb-1 font-weight-bold"><?php echo e(trans('admin/main.aff_sales_commission_hint')); ?></div>
                    <div class="text-small font-600-bold"><?php echo e(trans('admin/main.aff_sales_commission_desc')); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detail Modal -->
<div class="modal fade" id="affiliateDetailModal" tabindex="-1" role="dialog" aria-labelledby="affiliateDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="affiliateDetailModalLabel">Affiliate Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Webinar ID</th>
                            <th>Amount</th>
                            <th>Join Date</th>
                            <th>Paid</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody id="affiliateDetailTableBody">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts_bottom'); ?>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/js/admin/referrals/users.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sophis/academy.sophistec.dev/resources/views/admin/referrals/users.blade.php ENDPATH**/ ?>