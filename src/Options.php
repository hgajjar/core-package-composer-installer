<?php

namespace AydinHassan\MagentoCoreComposerInstaller;

/**
 * Class Options
 * @package AydinHassan\MagentoCoreComposerInstaller
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Options
{
    /**
     * @var array Any path which start with any of these
     * entries should be ignored
     */
    protected $deployExcludes = array(
        ".git",
        "composer.lock",
        "composer.json",
    );

    /**
     * @var array Directories to ignore
     * to reduce the size of the git ignore
     */
    protected $ignoreDirectories = [];

    /**
     * Whether to append to the existing git ignore or remove it
     * and start fresh
     *
     * @var bool
     */
    protected $appendToGitIgnore = true;

    /**
     * Whether the git ignore functionality is enabled
     *
     * @var bool
     */
    protected $gitIgnoreFunctionalityEnabled = true;

    /**
     * Magento Root Directory
     *
     * @var string
     */
    protected $coreRootDir;

    /**
     * Name of Magento Core Package
     *
     * @var string
     */
    protected $corePackageType = 'magento-core';

    /**
     * @var string
     */
    protected $corePackageName;

    /**
     * @param array $packageExtra
     */
    public function __construct(array $packageExtra)
    {
        $coreInstallerOptions = array();
        if (isset($packageExtra['core-deploy']) && is_array($packageExtra['core-deploy'])) {
            $coreInstallerOptions = $packageExtra['core-deploy'];
        }

        //merge excludes from root package composer.json file with default excludes
        if (isset($coreInstallerOptions['excludes'])) {

            if (!is_array($coreInstallerOptions['excludes'])) {
                throw new \InvalidArgumentException("excludes must be an array of files/directories to ignore");
            }
            $this->deployExcludes = array_merge($this->deployExcludes, $coreInstallerOptions['excludes']);
        }

        //overwrite default ignore directories if some are specified in root package composer.json
        if (isset($coreInstallerOptions['ignore-directories'])) {

            if (!is_array($coreInstallerOptions['ignore-directories'])) {
                throw new \InvalidArgumentException("ignore-directories must be an array of files/directories");
            }
            $this->ignoreDirectories = $coreInstallerOptions['ignore-directories'];
        }

        if (isset($coreInstallerOptions['git-ignore-enable'])) {
            $this->gitIgnoreFunctionalityEnabled = (bool) $coreInstallerOptions['git-ignore-enable'];
        }

        if (isset($coreInstallerOptions['git-ignore-append'])) {
            $this->appendToGitIgnore = (bool) $coreInstallerOptions['git-ignore-append'];
        }

        if (!isset($packageExtra['core-root-dir'])) {
            throw new \InvalidArgumentException("core-root-dir must be specified in root package");
        }

        if (isset($packageExtra['core-package-type'])) {
            $this->corePackageType = $packageExtra['core-package-type'];
        }

        if (isset($packageExtra['core-package-name'])) {
            $this->corePackageName = $packageExtra['core-package-name'];
        }

        $this->coreRootDir = rtrim($packageExtra['core-root-dir'], "/");
    }

    /**
     * @return array
     */
    public function getDeployExcludes()
    {
        return $this->deployExcludes;
    }

    /**
     * @return array
     */
    public function getIgnoreDirectories()
    {
        return $this->ignoreDirectories;
    }

    /**
     * @return bool
     */
    public function gitIgnoreFunctionalityEnabled()
    {
        return $this->gitIgnoreFunctionalityEnabled;
    }

    /**
     * @return boolean
     */
    public function appendToGitIgnore()
    {
        return $this->appendToGitIgnore;
    }

    /**
     * @return string
     */
    public function getCoreRootDir()
    {
        return $this->coreRootDir;
    }

    /**
     * @return string
     */
    public function getCorePackageType()
    {
        return $this->corePackageType;
    }

    /**
     * @return string|null
     */
    public function getCorePackageName()
    {
        return $this->corePackageName;
    }
}
