<?php namespace Nova\Setup;

use Exception;
use Spatie\Backup\Exceptions\InvalidBackupJob;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use Spatie\Backup\Tasks\Backup\BackupJob as BaseBackupJob;

class BackupJob extends BaseBackupJob
{
	public function run()
	{
		$this->temporaryDirectory = (new TemporaryDirectory())->create();

		if (! count($this->backupDestinations)) {
			throw InvalidBackupJob::noDestinationsSpecified();
		}

		$manifest = $this->createBackupManifest();

		if (! $manifest->count()) {
			throw InvalidBackupJob::noFilesToBeBackedUp();
		}

		$zipFile = $this->createZipContainingEveryFileInManifest($manifest);

		$this->copyToBackupDestinations($zipFile);

		$this->temporaryDirectory->delete();

		return true;
	}
}
