<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\MigrationCenterAPI;

class ComputeEnginePreferences extends \Google\Model
{
  /**
   * @var string
   */
  public $licenseType;
  protected $machinePreferencesType = MachinePreferences::class;
  protected $machinePreferencesDataType = '';
  public $machinePreferences;
  /**
   * @var string
   */
  public $persistentDiskType;

  /**
   * @param string
   */
  public function setLicenseType($licenseType)
  {
    $this->licenseType = $licenseType;
  }
  /**
   * @return string
   */
  public function getLicenseType()
  {
    return $this->licenseType;
  }
  /**
   * @param MachinePreferences
   */
  public function setMachinePreferences(MachinePreferences $machinePreferences)
  {
    $this->machinePreferences = $machinePreferences;
  }
  /**
   * @return MachinePreferences
   */
  public function getMachinePreferences()
  {
    return $this->machinePreferences;
  }
  /**
   * @param string
   */
  public function setPersistentDiskType($persistentDiskType)
  {
    $this->persistentDiskType = $persistentDiskType;
  }
  /**
   * @return string
   */
  public function getPersistentDiskType()
  {
    return $this->persistentDiskType;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ComputeEnginePreferences::class, 'Google_Service_MigrationCenterAPI_ComputeEnginePreferences');
