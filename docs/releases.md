# Releases

Anodyne manages its releases through a time-based model; a new Nova release will be available every 6 months: one in June and one in December.

## Development

The 6-month period is divided into two phases:

- Development: 4 months to add new features and to enhance existing ones;
- Stabilization: 2 months to fix bugs, test and prepare the release, and wait for the community (3rd-party libraries, modules, and skins) to catch up.

During the development phase, any new feature can be reverted if it won't be finished in time or won't be stable enough to be included in the next release.

## Maintenance

Each Nova version is maintained for a fixed period of time. We have two maintenance periods:

- Bug fixes and security fixes: During this period, all issues can be fixed. The end of this period is referenced as being the end of maintenance of a release. Nova releases will stay in this period for the 6 months between release and the release of a new version.
- Security fixes only: During this period, only security related issues can be fixed. The end of this period is referenced as being the end of life of a release. Nova releases will stay in this period for 6 months beyond the end of the previous period.

Simply put, bug fixes will be made to a release for 6 months and for the following 6 months, only security fixes will be made. This ensures that a version of Nova is maintained for 1 year following its release.

## Schedule

- 3.0
	- Release: 6/2015
	- End of Maintenance: 12/2015
	- End of Life: 6/2016
- 3.1
	- Release: 12/2015
	- End of Maintenance: 6/2016
	- End of Life: 12/2016
- 3.2
	- Release: 6/2016
	- End of Maintenance: 12/2016
	- End of Life: 6/2017
- 3.3
	- Release: 12/2016
	- End of Maintenance: 6/2017
	- End of Life: 12/2017

## Rationale

This release process was adopted to give more predictability and transparency. It has the following goals:

- Shorten the release cycle (allow games and developers to benefit from the new features faster);
- Improve the experience of games using Nova: everyone knows when a feature might be available in Nova;
- Coordinate the Nova timeline with projects that Nova is built on top of (namely Symfony and Laravel which have a May/November release timeframe);
- Give time to the community to catch up with the new versions (module authors, documentation writers, translators, skin developers, ...).

The six month period was chosen as two releases fit in a year. It also allows for plenty of time to work on new features and it allows for non-ready features to be postponed to the next version without having to wait too long for the next cycle.