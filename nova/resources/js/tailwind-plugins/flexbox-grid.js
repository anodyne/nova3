const round = require('lodash/round');

module.exports = ({
    gridColumns = 12
} = {}) => (options) => {
    const { addComponents, theme } = options;
    const columnIterator = Array.from(Array(gridColumns), (value, index) => index + 1);

    const row = {
        '.row': {
            display: 'flex',
            flexWrap: 'wrap',
            marginLeft: `-${theme('spacing.4')}`,
            marginRight: `-${theme('spacing.4')}`,
            '&.no-gutters': {
                marginLeft: 0,
                marginRight: 0
            }
        }
    };

    const columns = {
        '.no-gutters': {
            '> .col, > [class*="col-"]': {
                paddingLeft: 0,
                paddingRight: 0
            }
        },
        '.col, [class*= "col-"]': {
            display: 'flex',
            alignItems: 'center',
            position: 'relative',
            width: '100%',
            paddingLeft: theme('spacing.4'),
            paddingRight: theme('spacing.4')
        },
        '@variants responsive': {
            '.col': {
                flex: '1 1 0%'
            },
            '.col-auto': {
                width: 'auto',
                flexShrink: '1',
                flexGrow: '0'
            }
        }
    };

    const dynamicColumns = columnIterator.map((number) => {
        const percentage = `${round((number / gridColumns) * 100, 4)}%`;

        return {
            '@variants responsive': {
                [`.col-${number}`]: {
                    flexBasis: percentage,
                    maxWidth: percentage
                },
                [`.col-offset-${number}`]: {
                    marginLeft: percentage
                }
            }
        };
    });

    addComponents(row);
    addComponents(columns);
    addComponents(dynamicColumns);
};
