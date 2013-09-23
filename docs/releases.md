# Releases and Versioning

## Types of Releases

Beginning with Nova 3, we will differentiate between 3 different types of releases:

- Feature Release: a feature release will introduce new functionality and may also address existing issues and security issues with previous versions of Nova. A feature release will bump the major and/or minor version of Nova.
- Issue Release: an issue release will address known issues with the software. Backwards compatability will never be broken with an issue release. An issue release will bump the patch number of the current version. No new functionality will be added through these releases.
- Security Release: a security release will address any issues that relate solely to the security of the software. Just because a security release is made available does not mean there is a security vulnerability in the software that users should be worried about. Due to the nature of security releases, Anodyne will not make a changelog available. Security releases will bump the patch number of the current version. No new functionality will be added and existing issues that aren't related to security will not be addressed.

## Versions

We version under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

- Architectural changes and anything that significantly breaks backward compatibility bumps the major (and resets the minor and patch)
- New additions without significantly breaking backward compatibility bumps the minor (and resets the patch)
- Issue fixes and miscellaneous changes bumps the patch

## Release Timeline

Beginning with Nova 3, Anodyne will manages releases through a time-based model. New Nova releases will be available every 6 months: one in January and one in July. The decision to move to this schedule provides more predictability to when Nova 3 updates are released.

The 6-month period is divided into two phases:

- Development: 4 months to add new features and to enhance existing ones;
- Stabilization: 2 months to fix bugs, test and prepare the release, and give the community (3rd-party libraries, modules, and skins) a chance to catch up.

## Maintenance

Beginning with Nova 3, every version will be maintained for 1 year following its release. For the first 6 months, bug fixes will be made. The release of a new minor version marks the end of maintenance for that release. For the second 6 months, only security fixes will be made. A Nova 3 release is considered "end of life" after 2 new versions have been released.

## Schedule

- 3.0
	- Feature Release: 31 July 2015
	- Issue Releases Until: 31 January 2016
	- Security Releases Until: 31 July 2016
- 3.1
	- Feature Release: 31 January 2016
	- Issue Releases Until: 31 July 2016
	- Security Releases Until: 31 January 2017
- 3.2
	- Feature Release: 31 July 2016
	- Issue Releases Until: 31 January 2017
	- Security Releases Until: 31 July 2017
- 3.3
	- Feature Release: 31 January 2017
	- Issue Releases Until: 31 July 2017
	- Security Releases Until: 31 January 2018