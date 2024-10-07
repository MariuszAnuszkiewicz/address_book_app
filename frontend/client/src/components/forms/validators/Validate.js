import React from 'react';
import PropTypes from 'prop-types';

const Validate = ({errors, min, max}) => {

    let prepareFieldName = (field) => {
        const splitCamelCase = field.replace(/([a-z])([A-Z])/g, '$1 $2');
        return field.charAt(0).toLocaleUpperCase() + splitCamelCase.slice(1).replace('_', ' ');
    };

    for (const field of Object.keys(errors)) {
        const fieldName = prepareFieldName(field);

        if (errors[field] && errors[field]?.type === 'required') {
            return (
                <p className="error-message"><b>{fieldName}</b> is required</p>
            )
        }
        if (errors[field] && errors[field]?.type === 'minLength') {
            return (
                <p className="error-message"><b>{fieldName}</b> should be min {min} character.</p>
            )
        }
        if (errors[field] && errors[field]?.type === 'maxLength') {
            return (
                <p className="error-message"><b>{fieldName}</b> should be max {max} character.</p>
            )
        }
    }
}

Validate.propTypes = {
    errors: PropTypes.object,
    min: PropTypes.number,
    max: PropTypes.number,
}

export default Validate;