<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearTmpUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:tmp-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa các ảnh tạm thời đã tồn tại quá 24 giờ';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = File::files(storage_path('app/tmp_uploads'));

        foreach ($files as $file) {
            // Kiểm tra nếu file đã tồn tại hơn 24 giờ
            if (now()->diffInHours($file->getMTime()) > 24) {
                File::delete($file->getPathname());
            }
        }

        $this->info('Dọn dẹp thành công các ảnh tạm đã cũ.');
    }
}
