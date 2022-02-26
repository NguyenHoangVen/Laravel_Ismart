<?php

use Illuminate\Support\Facades\Log;

function deleteModel($id, $model) {
    try {
        $model->find($id)->delete();
        return json_encode([
            'code' => 200,
            'message' => 'Success'
        ]);
    } catch (\Exception $e) {
        Log::error('Lỗi: ' . $e->getMessage() . '---Line: ' . $e->getLine());
        return json_encode([
            'code' => 500,
            'message' => 'Error'
        ]);
    }
}
