# Releases

## Versioning

We version under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

- Architectural changes and anything that significantly breaks backward compatibility bumps the major (and resets the minor and patch)
- New additions without significantly breaking backward compatibility bumps the minor (and resets the patch)
- Issue fixes and miscellaneous changes bumps the patch

## Types of Releases

Beginning with Nova 3, we will differentiate between 3 different types of releases:

- Feature Release: a feature release will introduce new functionality and may also address existing issues and security issues with previous versions of the software. A feature release will bump the major and/or minor version. Feature releases that bump the major will include architectural changes or changes that significantly break backward compatibility.
- Issue Release: an issue release will address known issues with the software. Backwards compatability will never be broken with an issue release. An issue release will bump the patch number of the current version. No new functionality will be added through these releases.
- Security Release: a security release will address any issues that relate solely to the security of the software. Just because a security release is made available does not mean there is a security vulnerability in the software that users should be worried about. Due to the nature of security releases, Anodyne will not make a changelog available. Security releases will bump the patch number of the current version. No new functionality will be added and existing issues that aren't related to security will not be addressed.

## Release Timeline

Beginning with Nova 3, Anodyne will manage releases through a time-based model. Nova feature releases will be available every 6 months: one in January and one in July. Issue and Security releases will be made available as necessary over the course of the year. The decision to move to this schedule provides more predictability to when updates will be available.

The 6-month period is divided into two phases:

- Development: ~4 months to add new features and to enhance existing ones
- Stabilization: ~2 months to fix bugs, test and prepare the release, and give the community (3rd-party libraries, modules, and skins) a chance to catch up.

## Maintenance

Beginning with Nova 3, every version will be maintained for 1 year following its release. For the first 6 months, issue releases will be made available. The release of a new minor version marks the end of maintenance for that release. For the second 6 months, only security releases will be made. A feature release is considered "end of life" after 2 new feature releases have been made available.

## Schedule

- 3.0
	- Feature Release: January 2016
	- Issue Releases Until: July 2016
	- Security Releases Until: January 2017
- 3.1
	- Feature Release: July 2016
	- Issue Releases Until: January 2017
	- Security Releases Until: July 2017
- 3.2
	- Feature Release: January 2017
	- Issue Releases Until: July 2017
	- Security Releases Until: January 2018
- 3.3
	- Feature Release: July 2017
	- Issue Releases Until: January 2018
	- Security Releases Until: July 2018