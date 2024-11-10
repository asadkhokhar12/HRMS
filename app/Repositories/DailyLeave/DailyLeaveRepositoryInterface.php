<?php

namespace App\Repositories\DailyLeave;

interface DailyLeaveRepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create(array $data);

    public function fields();

    public function table($request);

    public function getUserAssignLeave();

    public function approveOrRejectOrCancel($id, $status);
    
    public function destroy($id);

    public function update($id, array $data);

    public function delete($id);

    public function updateStatus($id, $status);

    public function statusUpdate($request);
    
    public function destroyAll($request);
}
